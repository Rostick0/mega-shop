package entity

import "time"

type Product struct {
	ID         int64
	Title      string
	OldPrice   float32
	Price      float32   
	CategoryId *int64    
	Rating     *float32  
	IsShow     bool
	IsChecked  bool
	Slug       string
	CreatedAt  time.Time 
	UpdatedAt  time.Time 
}