package database

import (
	"fmt"
	"log"

	"os"

	"gorm.io/driver/postgres"
	"gorm.io/gorm"
)

var DB *gorm.DB

type Config struct {
	DBHost     string
	DBPort     int
	DBUser     string
	DBPassword string
}

func Connect() *gorm.DB {
	dbHost := os.Getenv("DB_HOST")
	dbPort := os.Getenv("DB_PORT")
	dbUser := os.Getenv("DB_USERNAME")
	dbPassword := os.Getenv("DB_PASSWORD")
	dbName := os.Getenv("DB_DATABASE")

    dsn := fmt.Sprintf("host=%s user=%s password=%s dbname=%s port=%s sslmode=disable",
        dbHost, dbUser, dbPassword, dbName, dbPort)

	var err error

	DB, err = gorm.Open(postgres.Open(dsn), &gorm.Config{})

	if err != nil {
		log.Fatal("Ошибка: ", err)
	}

	fmt.Println("Успешное подключение к бд")

	return DB
}
