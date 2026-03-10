package controller

import (
    "net/http"
    "strconv"

    "app/internal/modules/product/application/query/get_product"
    "app/internal/modules/product/application/query/get_product_by_slug"
)

type ProductHTTPHandler struct {
    get_product *get_product.GetProductHandler
    get_product_by_slug *get_product_by_slug.GetProductHandler
}

func NewProductHTTPHandler(get_product *get_product.GetProductHandler, get_product_by_slug *get_product_by_slug.GetProductHandler) *ProductHTTPHandler {
    return &ProductHTTPHandler{get_product: get_product, get_product_by_slug: get_product_by_slug}
}

func (h *ProductHTTPHandler) GetByID(w http.ResponseWriter, r *http.Request) {
    id, err := strconv.ParseInt(r.PathValue("id"), 10, 64)
    if err != nil {
        writeErr(w, http.StatusBadRequest, err)
        return
    }

    view, err := h.get_product.Handle(r.Context(), get_product.GetProductQuery{ProductId: id})
    if err != nil {
        writeErr(w, http.StatusInternalServerError, err)
        return
    }
    if view == nil {
        writeErr(w, http.StatusNotFound, nil)
        return
    }

    writeJSON(w, http.StatusOK, view)
}

func (h *ProductHTTPHandler) GetBySlug(w http.ResponseWriter, r *http.Request) {
    slug := r.PathValue("slug")
    if slug == "" {
        writeErr(w, http.StatusBadRequest, nil)
        return
    }

    view, err := h.get_product_by_slug.Handle(r.Context(), get_product_by_slug.GetProductQuery{Slug: slug})
    if err != nil {
        writeErr(w, http.StatusInternalServerError, err)
        return
    }
    if view == nil {
        writeErr(w, http.StatusNotFound, nil)
        return
    }

    writeJSON(w, http.StatusOK, view)
}
