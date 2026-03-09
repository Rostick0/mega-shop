package main

import (
	"fmt"
	"net/http"
	"github.com/joho/godotenv"
	
	"app/internal/config"
 	
	"app/internal/modules/product/application/query"
    "app/internal/modules/product/infrastructure/persistence"
    "app/internal/modules/product/presentation/http/controller"
	
	"app/internal/routes"

)

var serverPort = "8080"

func main() {
	if err := godotenv.Load(); err != nil {
        fmt.Print("no .env file, reading from environment")
    }

	dbCfg := config.LoadDBConfig()
    db, err := config.NewPostgresDB(dbCfg)
	  if err != nil {
        fmt.Print("failed to connect to db: %v", err)
    }
    defer db.Close()

	repo    := persistence.NewProductRepository(db)
    handler := query.NewGetProductHandler(repo)
    productHandler    := controller.NewProductHTTPHandler(handler)

	r := routes.NewRouter(productHandler)
	fmt.Print("Start server: http://localhost:" + serverPort)
	http.ListenAndServe(":"+serverPort, r)
}