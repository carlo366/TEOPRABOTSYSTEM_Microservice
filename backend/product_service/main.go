package main

import (
	"github.com/carlo366/microservices-go/backend/product_service/config"
	"github.com/carlo366/microservices-go/backend/product_service/controller"
	"github.com/carlo366/microservices-go/backend/product_service/repository"
	"github.com/carlo366/microservices-go/backend/product_service/service"
	"github.com/gin-gonic/gin"
	"gorm.io/gorm"
)

var (
	db                *gorm.DB                     = config.SetupDatabaseConnection()
	productRepository repository.ProductRepository = repository.NewProductRepository(db)
	ProductService    service.ProductService       = service.NewProductService(productRepository)
	productController controller.ProductController = controller.NewProductController(ProductService)
)

// membuat variable db dengan nilai setup database connection
func main() {
	defer config.CloseDatabaseConnection(db)
	r := gin.Default()

	productRoutes := r.Group("/api/products")
	{
		productRoutes.GET("/", productController.All)
		productRoutes.POST("/", productController.Insert)
		productRoutes.GET("/:id", productController.FindByID)
		productRoutes.PUT("/:id", productController.Update)
		productRoutes.DELETE("/:id", productController.Delete)
	}
	r.Run(":8081")
}
