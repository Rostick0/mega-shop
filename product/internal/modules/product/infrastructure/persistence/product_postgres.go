package persistence

import (
	"context"
	"database/sql"
	"errors"
    product "app/internal/modules/product/domain/entity"
)

type productRepository struct {
	db *sql.DB
}

func NewProductRepository(db *sql.DB) *productRepository {
	return &productRepository{db: db}
}

func (r *productRepository) FindByID(ctx context.Context, id int64) (*product.Product, error) {
	// var product product.Product
	// if err := r.db.First(&product, id).Error; err != nil {
	// 	if errors.Is(err, sql.ErrNoRows) {
	// 		return nil, nil
	// 	}
	// 	return nil, err
	// }
	// return (&product), nil
	var p product.Product
    err := r.db.QueryRowContext(ctx, "SELECT id, title, price FROM products WHERE id = $1", id).
        Scan(&p.ID, &p.Title, &p.Price)
    if err != nil {
        if errors.Is(err, sql.ErrNoRows) {
            return nil, nil
        }
        return nil, err
    }
    return &p, nil
}