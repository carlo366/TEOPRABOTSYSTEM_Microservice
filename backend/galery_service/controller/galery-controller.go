package controller

import (
	"net/http"
	"strconv"

	"github.com/carlo366/microservices-go/backend/galery_service/dto"
	"github.com/carlo366/microservices-go/backend/galery_service/entity"
	"github.com/carlo366/microservices-go/backend/galery_service/helper"
	"github.com/carlo366/microservices-go/backend/galery_service/service"
	"github.com/gin-gonic/gin"
)

// GaleryController is a contract about something that this controller can do
type GaleryController interface {
	All(ctx *gin.Context)
	FindByID(ctx *gin.Context)
	Insert(ctx *gin.Context)
	Update(ctx *gin.Context)
	Delete(ctx *gin.Context)
}

type galeryController struct {
	galeryService service.GaleryService
}

// NewGaleryController creates a new instance of AuthController
func NewGaleryController(galeryService service.GaleryService) GaleryController {
	return &galeryController{
		galeryService: galeryService,
	}
}

func (c *galeryController) All(ctx *gin.Context) {
	var categories []entity.Galery = c.galeryService.All()
	res := helper.BuildResponse(true, "OK!", categories)
	ctx.JSON(http.StatusOK, res)
}

func (c *galeryController) FindByID(ctx *gin.Context) {
	id, err := strconv.ParseUint(ctx.Param("id"), 0, 0)
	if err != nil {
		res := helper.BuildErrorResponse("Failed to get ID", "No param ID were found", helper.EmptyObj{})
		ctx.JSON(http.StatusBadRequest, res)
		return
	}
	galery := c.galeryService.FindByID(id)
	if (galery == entity.Galery{}) {
		res := helper.BuildErrorResponse("Data not found", "No data with given ID", helper.EmptyObj{})
		ctx.JSON(http.StatusNotFound, res)
	} else {
		res := helper.BuildResponse(true, "OK!", galery)
		ctx.JSON(http.StatusOK, res)
	}
}

func (c *galeryController) Insert(ctx *gin.Context) {
	var galeryCreateDTO dto.GaleryCreateDTO
	errDTO := ctx.ShouldBind(&galeryCreateDTO)
	if errDTO != nil {
		res := helper.BuildErrorResponse("Failed to process request", errDTO.Error(), helper.EmptyObj{})
		ctx.JSON(http.StatusBadRequest, res)
		return
	}
	result := c.galeryService.Insert(galeryCreateDTO)
	response := helper.BuildResponse(true, "OK!", result)
	ctx.JSON(http.StatusCreated, response)
}

func (c *galeryController) Update(ctx *gin.Context) {
	var galeryUpdateDTO dto.GaleryUpdateDTO
	errDTO := ctx.ShouldBind(&galeryUpdateDTO)
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
	galeryUpdateDTO.ID = id
	result := c.galeryService.Update(galeryUpdateDTO)
	response := helper.BuildResponse(true, "OK!", result)
	ctx.JSON(http.StatusOK, response)
}

func (c *galeryController) Delete(ctx *gin.Context) {
	var galery entity.Galery
	id, errID := strconv.ParseUint(ctx.Param("id"), 0, 0)
	if errID != nil {
		res := helper.BuildErrorResponse("Failed to get ID", "No param ID were found", helper.EmptyObj{})
		ctx.JSON(http.StatusBadRequest, res)
		return
	}
	galery.ID = id
	c.galeryService.Delete(galery)
	res := helper.BuildResponse(true, "Deleted", helper.EmptyObj{})
	ctx.JSON(http.StatusOK, res)
}
