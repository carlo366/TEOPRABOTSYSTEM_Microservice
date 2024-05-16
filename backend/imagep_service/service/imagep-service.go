package service

import (
	"log"

	"github.com/carlo366/microservices-go/backend/imagep_service/dto"
	"github.com/carlo366/microservices-go/backend/imagep_service/entity"
	"github.com/carlo366/microservices-go/backend/imagep_service/repository"
	"github.com/mashingan/smapping"
)

type ImagepService interface {
	Insert(b dto.ImagepCreateDTO) entity.Imagep
	Update(b dto.ImagepUpdateDTO) entity.Imagep
	Delete(b entity.Imagep)
	All() []entity.Imagep
	FindByID(imagepID uint64) entity.Imagep
}

type imagepService struct {
	imagepRepository repository.ImagepRepository
}

// NewImagepService creates a new instance of ImagepService
func NewImagepService(imagepRepository repository.ImagepRepository) ImagepService {
	return &imagepService{
		imagepRepository: imagepRepository,
	}
}

func (service *imagepService) All() []entity.Imagep {
	return service.imagepRepository.All()
}

func (service *imagepService) FindByID(imagepID uint64) entity.Imagep {
	return service.imagepRepository.FindByID(imagepID)
}

func (service *imagepService) Insert(b dto.ImagepCreateDTO) entity.Imagep {
	imagep := entity.Imagep{}
	err := smapping.FillStruct(&imagep, smapping.MapFields(&b))
	if err != nil {
		log.Fatalf("Failed map %v: ", err)
	}
	res := service.imagepRepository.InsertImagep(imagep)
	return res
}

func (service *imagepService) Update(b dto.ImagepUpdateDTO) entity.Imagep {
	imagep := entity.Imagep{}
	err := smapping.FillStruct(&imagep, smapping.MapFields(&b))
	if err != nil {
		log.Fatalf("Failed map %v: ", err)
	}
	res := service.imagepRepository.UpdateImagep(imagep)
	return res
}

func (service *imagepService) Delete(b entity.Imagep) {
	service.imagepRepository.DeleteImagep(b)
}
