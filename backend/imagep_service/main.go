package main

import (
	"github.com/carlo366/microservices-go/backend/imagep_service/config"
	"github.com/carlo366/microservices-go/backend/imagep_service/controller"
	"github.com/carlo366/microservices-go/backend/imagep_service/repository"
	"github.com/carlo366/microservices-go/backend/imagep_service/service"
	"github.com/gin-gonic/gin"
	"gorm.io/gorm"
)

var (
	db               *gorm.DB                    = config.SetupDatabaseConnection()
	imagepRepository repository.ImagepRepository = repository.NewImagepRepository(db)
	imagepService    service.ImagepService       = service.NewImagepService(imagepRepository)
	imagepController controller.ImagepController = controller.NewImagepController(imagepService)
)

func main() {
	defer config.CloseDatabaseConnection(db)
	r := gin.Default()

	imagepRoutes := r.Group("/api/imagep")
	{
		imagepRoutes.GET("/", imagepController.All)
		imagepRoutes.POST("/", imagepController.Insert)
		imagepRoutes.GET("/:id", imagepController.FindByID)
		imagepRoutes.PUT("/:id", imagepController.Update)
		imagepRoutes.DELETE("/:id", imagepController.Delete)
	}
	r.Run(":9091")
}
