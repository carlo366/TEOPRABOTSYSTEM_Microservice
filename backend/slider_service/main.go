package main

import (
	"github.com/carlo366/microservices-go/backend/slider_service/config"
	"github.com/carlo366/microservices-go/backend/slider_service/controller"
	"github.com/carlo366/microservices-go/backend/slider_service/repository"
	"github.com/carlo366/microservices-go/backend/slider_service/service"
	"github.com/gin-gonic/gin"
	"gorm.io/gorm"
)

var (
	db               *gorm.DB                    = config.SetupDatabaseConnection()
	sliderRepository repository.SliderRepository = repository.NewSliderRepository(db)
	sliderService    service.SliderService       = service.NewSliderService(sliderRepository)
	sliderController controller.SliderController = controller.NewSliderController(sliderService)
)

func main() {
	defer config.CloseDatabaseConnection(db)
	r := gin.Default()

	sliderRoutes := r.Group("/api/slider")
	{
		sliderRoutes.GET("/", sliderController.All)
		sliderRoutes.POST("/", sliderController.Insert)
		sliderRoutes.GET("/:id", sliderController.FindByID)
		sliderRoutes.PUT("/:id", sliderController.Update)
		sliderRoutes.DELETE("/:id", sliderController.Delete)
	}
	r.Run(":9092")
}
