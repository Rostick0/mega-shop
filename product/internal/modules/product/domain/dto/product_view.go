package dto

import (
	"time"
)

type ProductView struct {
	ID         int64 `json:"id"`
	Title      string `json:"title"`
	OldPrice   float32 `json:"old_price"`
	Price      float32 `json:"price"`
	CategoryId *int64 `json:"category_id"`
	Rating     *float32 `json:"rating"`
	Slug       string `json:"slug"`
	CreatedAt  time.Time `json:"created_at"`
}