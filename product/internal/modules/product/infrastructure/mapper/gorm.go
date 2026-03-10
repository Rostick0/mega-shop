package mapper

import (
    "app/internal/modules/product/domain/entity"
    "app/internal/modules/product/infrastructure/model"
)

func ToEntity(m *model.ProductModel) *entity.Product {
    return &entity.Product{
        ID:         m.ID,
        Title:      m.Title,
        OldPrice:   m.OldPrice,
        Price:      m.Price,
        CategoryId: m.CategoryId,
        Rating:     m.Rating,
        IsShow:     m.IsShow,
        IsChecked:  m.IsChecked,
        Slug:       m.Slug,
        CreatedAt:  m.CreatedAt,
        UpdatedAt:  m.UpdatedAt,
    }
}

func FromEntity(p *entity.Product) *model.ProductModel {
    return &model.ProductModel{
        ID:         p.ID,
        Title:      p.Title,
        OldPrice:   p.OldPrice,
        Price:      p.Price,
        CategoryId: p.CategoryId,
        Rating:     p.Rating,
        IsShow:     p.IsShow,
        IsChecked:  p.IsChecked,
        Slug:       p.Slug,
        CreatedAt:  p.CreatedAt,
        UpdatedAt:  p.UpdatedAt,
    }
}