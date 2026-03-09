package routes

import (
	"net/http"

	"github.com/go-chi/chi/v5"

	"app/internal/modules/product/presentation/http/controller"
)

func NewRouter(ProductHandler *controller.ProductHTTPHandler) http.Handler {
	r := chi.NewRouter()
	// json.Middleware a := json.Middleware
	//
	// jsonMiddleware.
	// r.Use(*jsonMiddleware) // устанавливаем заголовок для всех маршрутов
	// http.Request.Header ("Content-Type", "application/json")

	// маршруты для категории
	// r.Route("/categories", func(r chi.Router) {
	// 	r.Get("/", CategoryHandler.GetCategories)
	// 	r.Get("/{id}", CategoryHandler.GetCategory)
	// 	// r.Post("/", userHandler.Create)
	// })

	r.Route("/products", func(r chi.Router) {
		// w.Header().Set("Content-Type", "application/json")
		// r.Get("/", ProductHandler.GetList)
		r.Get("/{id}", ProductHandler.GetByID)
		// r.Post("/", ProductHandler.Create)
		// r.Put("/{id}", ProductHandler.Update)
		// r.Patch("/{id}", ProductHandler.Update)
		// r.Delete("/{id}", ProductHandler.Delete)
	})

	r.Mount("/api", r)

	return r
}
