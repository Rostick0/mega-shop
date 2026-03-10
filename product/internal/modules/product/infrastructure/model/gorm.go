package model

import "time"

type ProductModel struct {
    ID         int64     `gorm:"primaryKey;autoIncrement"`
    Title      string    `gorm:"not null"`
    OldPrice   float32   `gorm:"not null"`
    Price      float32   `gorm:"not null"`
    CategoryId *int64    `gorm:"index"`
    Rating     *float32  `gorm:"null"`
    IsShow     bool      `gorm:"default:false"`
    IsChecked  bool      `gorm:"default:false"`
    Slug       string    `gorm:"uniqueIndex;not null"`
    CreatedAt  time.Time `gorm:"autoCreateTime"`
    UpdatedAt  time.Time `gorm:"autoUpdateTime"`
}

func (ProductModel) TableName() string {
    return "products"
}