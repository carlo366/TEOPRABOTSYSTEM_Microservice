package main

import (
	"github.com/carlo366/microservices-go/backend/category_service/config"
	"github.com/carlo366/microservices-go/backend/category_service/controller"
	"github.com/carlo366/microservices-go/backend/category_service/repository"
	"github.com/carlo366/microservices-go/backend/category_service/service"
	"github.com/gin-gonic/gin"
	"gorm.io/gorm"
)

var (
	db                 *gorm.DB                      = config.SetupDatabaseConnection()
	categoryRepository repository.CategoryRepository = repository.NewCategoryRepository(db)
	categoryService    service.CategoryService       = service.NewCategoryService(categoryRepository)
	categoryController controller.CategoryController = controller.NewCategoryController(categoryService)
)

func main() {
	defer config.CloseDatabaseConnection(db)
	r := gin.Default()

	categoryRoutes := r.Group("/api/categories")
	{
		categoryRoutes.GET("/", categoryController.All)
		categoryRoutes.POST("/", categoryController.Insert)
		categoryRoutes.GET("/:id", categoryController.FindByID)
		categoryRoutes.PUT("/:id", categoryController.Update)
		categoryRoutes.DELETE("/:id", categoryController.Delete)
	}
	r.Run(":9090")
}
