package main

import (
	"github.com/carlo366/microservices-go/backend/galery_service/config"
	"github.com/carlo366/microservices-go/backend/galery_service/controller"
	"github.com/carlo366/microservices-go/backend/galery_service/repository"
	"github.com/carlo366/microservices-go/backend/galery_service/service"
	"github.com/gin-gonic/gin"
	"gorm.io/gorm"
)

var (
	db               *gorm.DB                    = config.SetupDatabaseConnection()
	galeryRepository repository.GaleryRepository = repository.NewGaleryRepository(db)
	galeryService    service.GaleryService       = service.NewGaleryService(galeryRepository)
	galeryController controller.GaleryController = controller.NewGaleryController(galeryService)
)

func main() {
	defer config.CloseDatabaseConnection(db)
	r := gin.Default()

	galeryRoutes := r.Group("/api/categories")
	{
		galeryRoutes.GET("/", galeryController.All)
		galeryRoutes.POST("/", galeryController.Insert)
		galeryRoutes.GET("/:id", galeryController.FindByID)
		galeryRoutes.PUT("/:id", galeryController.Update)
		galeryRoutes.DELETE("/:id", galeryController.Delete)
	}
	r.Run(":9094")
}
