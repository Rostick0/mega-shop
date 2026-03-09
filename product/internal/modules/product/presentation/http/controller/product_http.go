package controller

import (
    "net/http"
    "strconv"

    "app/internal/modules/product/application/query"
)

type ProductHTTPHandler struct {
    query *query.GetProductHandler
}

func NewProductHTTPHandler(q *query.GetProductHandler) *ProductHTTPHandler {
    return &ProductHTTPHandler{query: q}
}

func (h *ProductHTTPHandler) GetByID(w http.ResponseWriter, r *http.Request) {
    id, err := strconv.ParseInt(r.PathValue("id"), 10, 64)
    if err != nil {
        writeErr(w, http.StatusBadRequest, err)
        return
    }

    view, err := h.query.Handle(r.Context(), query.GetProductQuery{ProductId: id})
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