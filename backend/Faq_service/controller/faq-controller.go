package controller

import (
	"net/http"
	"strconv"

	"github.com/carlo366/microservices-go/backend/faq_service/dto"
	"github.com/carlo366/microservices-go/backend/faq_service/entity"
	"github.com/carlo366/microservices-go/backend/faq_service/helper"
	"github.com/carlo366/microservices-go/backend/faq_service/service"
	"github.com/gin-gonic/gin"
)

// FaqController is a contract about something that this controller can do
type FaqController interface {
	All(ctx *gin.Context)
	FindByID(ctx *gin.Context)
	Insert(ctx *gin.Context)
	Update(ctx *gin.Context)
	Delete(ctx *gin.Context)
}

type faqController struct {
	faqService service.FaqService
}

// NewFaqController creates a new instance of FaqController
func NewFaqController(faqService service.FaqService) FaqController {
	return &faqController{
		faqService: faqService,
	}
}

func (c *faqController) All(ctx *gin.Context) {
	var faqs []entity.Faq = c.faqService.All()
	res := helper.BuildResponse(true, "OK!", faqs)
	ctx.JSON(http.StatusOK, res)
}

func (c *faqController) FindByID(ctx *gin.Context) {
	id, err := strconv.ParseUint(ctx.Param("id"), 0, 0)
	if err != nil {
		res := helper.BuildErrorResponse("Failed to get ID", "No param ID were found", helper.EmptyObj{})
		ctx.JSON(http.StatusBadRequest, res)
		return
	}
	faq := c.faqService.FindByID(id)
	if (faq == entity.Faq{}) {
		res := helper.BuildErrorResponse("Data not found", "No data with given ID", helper.EmptyObj{})
		ctx.JSON(http.StatusNotFound, res)
	} else {
		res := helper.BuildResponse(true, "OK!", faq)
		ctx.JSON(http.StatusOK, res)
	}
}

func (c *faqController) Insert(ctx *gin.Context) {
	var faqCreateDTO dto.FaqCreateDTO
	errDTO := ctx.ShouldBind(&faqCreateDTO)
	if errDTO != nil {
		res := helper.BuildErrorResponse("Failed to process request", errDTO.Error(), helper.EmptyObj{})
		ctx.JSON(http.StatusBadRequest, res)
		return
	}
	result := c.faqService.Insert(faqCreateDTO)
	response := helper.BuildResponse(true, "OK!", result)
	ctx.JSON(http.StatusCreated, response)
}

func (c *faqController) Update(ctx *gin.Context) {
	var faqUpdateDTO dto.FaqUpdateDTO
	errDTO := ctx.ShouldBind(&faqUpdateDTO)
	if errDTO != nil {
		res := helper.BuildErrorResponse("Failed to process request", errDTO.Error(), helper.EmptyObj{})
		ctx.JSON(http.StatusBadRequest, res)
		return
	}
	id, errID := strconv.ParseUint(ctx.Param("id"), 0, 0)
	if errID != nil {
		res := helper.BuildErrorResponse("Failed to get ID", "No param ID were found", helper.EmptyObj{})
		ctx.JSON(http.StatusBadRequest, res)
		return
	}
	faqUpdateDTO.ID = id
	result := c.faqService.Update(faqUpdateDTO)
	response := helper.BuildResponse(true, "OK!", result)
	ctx.JSON(http.StatusOK, response)
}

func (c *faqController) Delete(ctx *gin.Context) {
	var faq entity.Faq
	id, errID := strconv.ParseUint(ctx.Param("id"), 0, 0)
	if errID != nil {
		res := helper.BuildErrorResponse("Failed to get ID", "No param ID were found", helper.EmptyObj{})
		ctx.JSON(http.StatusBadRequest, res)
		return
	}
	faq.ID = id
	c.faqService.Delete(faq)
	res := helper.BuildResponse(true, "Deleted", helper.EmptyObj{})
	ctx.JSON(http.StatusOK, res)
}
