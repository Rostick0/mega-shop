package main

import (
	"github.com/joho/godotenv"
	
	"app/internal/config"

	productModel "app/internal/modules/product/infrastructure/model"
 )

func main() {
	godotenv.Load()
	
	db := database.Connect()

	db.AutoMigrate(&productModel.ProductModel{})
}