package main

import (
	"github.com/carlo366/microservices-go/backend/faq_service/config"
	"github.com/carlo366/microservices-go/backend/faq_service/controller"
	"github.com/carlo366/microservices-go/backend/faq_service/repository"
	"github.com/carlo366/microservices-go/backend/faq_service/service"
	"github.com/gin-gonic/gin"
	"gorm.io/gorm"
)

var (
	db            *gorm.DB                 = config.SetupDatabaseConnection()
	faqRepository repository.FaqRepository = repository.NewFaqRepository(db)
	faqService    service.FaqService       = service.NewFaqService(faqRepository)
	faqController controller.FaqController = controller.NewFaqController(faqService)
)

func main() {
	defer config.CloseDatabaseConnection(db)
	r := gin.Default()

	faqRoutes := r.Group("/api/faq")
	{
		faqRoutes.GET("/", faqController.All)
		faqRoutes.POST("/", faqController.Insert)
		faqRoutes.GET("/:id", faqController.FindByID)
		faqRoutes.PUT("/:id", faqController.Update)
		faqRoutes.DELETE("/:id", faqController.Delete)
	}
	r.Run(":9093")
}
