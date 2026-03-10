package persistence

import (
	"context"
	"gorm.io/gorm"
	"errors"
	"app/internal/modules/product/infrastructure/model"
	"app/internal/modules/product/infrastructure/mapper"
    product "app/internal/modules/product/domain/entity"
)

type productRepository struct {
	db *gorm.DB
}

func NewProductRepository(db *gorm.DB) *productRepository {
	return &productRepository{db: db}
}

func (r *productRepository) FindByID(ctx context.Context, id int64) (*product.Product, error) {
	var p model.ProductModel

   if err := r.db.First(&p, id).Error; err != nil {
		if errors.Is(err, gorm.ErrRecordNotFound) {
			return nil, nil // пользователь не найден
		}
		return nil, err // другая ошибка
	}

    return mapper.ToEntity(&p), nil
}

func (r *productRepository) FindBySlug(ctx context.Context, slug string) (*product.Product, error) {
	var p model.ProductModel

   if err := r.db.Where("slug = ?", slug).First(&p).Error; err != nil {
		if errors.Is(err, gorm.ErrRecordNotFound) {
			return nil, nil // пользователь не найден
		}
		return nil, err // другая ошибка
	}

    return mapper.ToEntity(&p), nil
}