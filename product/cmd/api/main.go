package main

import (
	"fmt"
	"net/http"
	"github.com/joho/godotenv"
	
	"app/internal/config"
 	
	"app/internal/modules/product/application/query/get_product"
	"app/internal/modules/product/application/query/get_product_by_slug"
    "app/internal/modules/product/infrastructure/persistence"
    "app/internal/modules/product/presentation/http/controller"
	
	"app/internal/routes"

)

var serverPort = "8080"

func main() {
	godotenv.Load()
	db := database.Connect()

	repo    := persistence.NewProductRepository(db)
    get_product_handler := get_product.NewGetProductHandler(repo)
    get_product_by_slug_handler := get_product_by_slug.NewGetProductHandler(repo)
    product_handler := controller.NewProductHTTPHandler(get_product_handler, get_product_by_slug_handler)

	r := routes.NewRouter(product_handler)
	fmt.Print("Start server: http://localhost:" + serverPort)
	http.ListenAndServe(":"+serverPort, r)
}