package domain

import (
	"context"
	"app/internal/modules/product/domain/entity"
)

type ProductWriter interface {
	Store(ctx context.Context, product *entity.Product) error
    Update(ctx context.Context, product *entity.Product) error
    Delete(ctx context.Context, id int64) error
}

type ProductReader interface {
    FindByID(ctx context.Context, id int64) (*entity.Product, error)
}