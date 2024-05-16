package service

import (
	"log"

	"github.com/carlo366/microservices-go/backend/galery_service/dto"
	"github.com/carlo366/microservices-go/backend/galery_service/entity"
	"github.com/carlo366/microservices-go/backend/galery_service/repository"
	"github.com/mashingan/smapping"
)

type GaleryService interface {
	Insert(b dto.GaleryCreateDTO) entity.Galery
	Update(b dto.GaleryUpdateDTO) entity.Galery
	Delete(b entity.Galery)
	All() []entity.Galery
	FindByID(galeryID uint64) entity.Galery
}

type galeryService struct {
	galeryRepository repository.GaleryRepository
}

// NewGaleryService creates a new instance of GaleryService
func NewGaleryService(galeryRepository repository.GaleryRepository) GaleryService {
	return &galeryService{
		galeryRepository: galeryRepository,
	}
}

func (service *galeryService) All() []entity.Galery {
	return service.galeryRepository.All()
}

func (service *galeryService) FindByID(galeryID uint64) entity.Galery {
	return service.galeryRepository.FindByID(galeryID)
}

func (service *galeryService) Insert(b dto.GaleryCreateDTO) entity.Galery {
	galery := entity.Galery{}
	err := smapping.FillStruct(&galery, smapping.MapFields(&b))
	if err != nil {
		log.Fatalf("Failed map %v: ", err)
	}
	res := service.galeryRepository.InsertGalery(galery)
	return res
}

func (service *galeryService) Update(b dto.GaleryUpdateDTO) entity.Galery {
	galery := entity.Galery{}
	err := smapping.FillStruct(&galery, smapping.MapFields(&b))
	if err != nil {
		log.Fatalf("Failed map %v: ", err)
	}
	res := service.galeryRepository.UpdateGalery(galery)
	return res
}

func (service *galeryService) Delete(b entity.Galery) {
	service.galeryRepository.DeleteGalery(b)
}
