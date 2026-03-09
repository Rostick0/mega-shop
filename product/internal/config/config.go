package config

import (
    "fmt"
    "os"
)

type DBConfig struct {
    Host     string
    Port     string
    Username string
    Password string
    Database string
}

func LoadDBConfig() DBConfig {
    return DBConfig{
        Host:     getEnv("DB_HOST", "localhost"),
        Port:     getEnv("DB_PORT", "5432"),
        Username: getEnv("DB_USERNAME", "root"),
        Password: getEnv("DB_PASSWORD", "root"),
        Database: getEnv("DB_DATABASE", "market"),
    }
}

func (c DBConfig) DSN() string {
    return fmt.Sprintf(
        "host=%s port=%s user=%s password=%s dbname=%s sslmode=disable",
        c.Host, c.Port, c.Username, c.Password, c.Database,
    )
}

func getEnv(key, fallback string) string {
    if val := os.Getenv(key); val != "" {
        return val
    }
    return fallback
}