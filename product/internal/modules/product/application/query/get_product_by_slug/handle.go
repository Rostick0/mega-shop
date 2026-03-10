package get_product_by_slug

import (
	"context"

    "app/internal/modules/product/domain"
	"app/internal/modules/product/domain/dto"
)

type GetProductQuery struct {
	Slug string
}

func (q GetProductQuery) QueryName() string {
	return "product.getBySlug"
}

type GetProductHandler struct {
	reader domain.ProductReader
}

func NewGetProductHandler(reader domain.ProductReader) *GetProductHandler {
	return &GetProductHandler{reader: reader}
}

func (handler *GetProductHandler) Handle(ctx context.Context, query GetProductQuery) (*dto.ProductView, error) {
	product, err := handler.reader.FindBySlug(ctx, query.Slug)

	if err != nil {
        return nil, err
    }

	return &dto.ProductView{
        ID:         product.ID,
        Title:      product.Title,
        OldPrice:   product.OldPrice,
        Price:      product.Price,
        CategoryId: product.CategoryId,
        Rating:     product.Rating,
        Slug:       product.Slug,
        CreatedAt:  product.CreatedAt,
    }, nil
}