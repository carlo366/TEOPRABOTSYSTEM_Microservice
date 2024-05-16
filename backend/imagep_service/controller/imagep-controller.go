package controller

import (
	"net/http"
	"strconv"

	"github.com/carlo366/microservices-go/backend/imagep_service/dto"
	"github.com/carlo366/microservices-go/backend/imagep_service/entity"
	"github.com/carlo366/microservices-go/backend/imagep_service/helper"
	"github.com/carlo366/microservices-go/backend/imagep_service/service"
	"github.com/gin-gonic/gin"
)

// ImagepController is a contract about something that this controller can do
type ImagepController interface {
	All(ctx *gin.Context)
	FindByID(ctx *gin.Context)
	Insert(ctx *gin.Context)
	Update(ctx *gin.Context)
	Delete(ctx *gin.Context)
}

type imagepController struct {
	imagepService service.ImagepService
}

// NewImagepController creates a new instance of ImagepController
func NewImagepController(imagepService service.ImagepService) ImagepController {
	return &imagepController{
		imagepService: imagepService,
	}
}

func (c *imagepController) All(ctx *gin.Context) {
	var imageps []entity.Imagep = c.imagepService.All()
	res := helper.BuildResponse(true, "OK!", imageps)
	ctx.JSON(http.StatusOK, res)
}

func (c *imagepController) FindByID(ctx *gin.Context) {
	id, err := strconv.ParseUint(ctx.Param("id"), 0, 0)
	if err != nil {
		res := helper.BuildErrorResponse("Failed to get ID", "No param ID were found", helper.EmptyObj{})
		ctx.JSON(http.StatusBadRequest, res)
		return
	}
	imagep := c.imagepService.FindByID(id)
	if (imagep == entity.Imagep{}) {
		res := helper.BuildErrorResponse("Data not found", "No data with given ID", helper.EmptyObj{})
		ctx.JSON(http.StatusNotFound, res)
	} else {
		res := helper.BuildResponse(true, "OK!", imagep)
		ctx.JSON(http.StatusOK, res)
	}
}

func (c *imagepController) Insert(ctx *gin.Context) {
	var imagepCreateDTO dto.ImagepCreateDTO
	errDTO := ctx.ShouldBind(&imagepCreateDTO)
	if errDTO != nil {
		res := helper.BuildErrorResponse("Failed to process request", errDTO.Error(), helper.EmptyObj{})
		ctx.JSON(http.StatusBadRequest, res)
		return
	}
	result := c.imagepService.Insert(imagepCreateDTO)
	response := helper.BuildResponse(true, "OK!", result)
	ctx.JSON(http.StatusCreated, response)
}

func (c *imagepController) Update(ctx *gin.Context) {
	var imagepUpdateDTO dto.ImagepUpdateDTO
	errDTO := ctx.ShouldBind(&imagepUpdateDTO)
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
	imagepUpdateDTO.ID = id
	result := c.imagepService.Update(imagepUpdateDTO)
	response := helper.BuildResponse(true, "OK!", result)
	ctx.JSON(http.StatusOK, response)
}

func (c *imagepController) Delete(ctx *gin.Context) {
	var imagep entity.Imagep
	id, errID := strconv.ParseUint(ctx.Param("id"), 0, 0)
	if errID != nil {
		res := helper.BuildErrorResponse("Failed to get ID", "No param ID were found", helper.EmptyObj{})
		ctx.JSON(http.StatusBadRequest, res)
		return
	}
	imagep.ID = id
	c.imagepService.Delete(imagep)
	res := helper.BuildResponse(true, "Deleted", helper.EmptyObj{})
	ctx.JSON(http.StatusOK, res)
}
