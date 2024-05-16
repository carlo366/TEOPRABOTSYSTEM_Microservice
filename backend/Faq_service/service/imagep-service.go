package service

import (
	"log"

	"github.com/carlo366/microservices-go/backend/faq_service/dto"
	"github.com/carlo366/microservices-go/backend/faq_service/entity"
	"github.com/carlo366/microservices-go/backend/faq_service/repository"
	"github.com/mashingan/smapping"
)

type FaqService interface {
	Insert(b dto.FaqCreateDTO) entity.Faq
	Update(b dto.FaqUpdateDTO) entity.Faq
	Delete(b entity.Faq)
	All() []entity.Faq
	FindByID(faqID uint64) entity.Faq
}

type faqService struct {
	faqRepository repository.FaqRepository
}

// NewFaqService creates a new instance of FaqService
func NewFaqService(faqRepository repository.FaqRepository) FaqService {
	return &faqService{
		faqRepository: faqRepository,
	}
}

func (service *faqService) All() []entity.Faq {
	return service.faqRepository.All()
}

func (service *faqService) FindByID(faqID uint64) entity.Faq {
	return service.faqRepository.FindByID(faqID)
}

func (service *faqService) Insert(b dto.FaqCreateDTO) entity.Faq {
	faq := entity.Faq{}
	err := smapping.FillStruct(&faq, smapping.MapFields(&b))
	if err != nil {
		log.Fatalf("Failed map %v: ", err)
	}
	res := service.faqRepository.InsertFaq(faq)
	return res
}

func (service *faqService) Update(b dto.FaqUpdateDTO) entity.Faq {
	faq := entity.Faq{}
	err := smapping.FillStruct(&faq, smapping.MapFields(&b))
	if err != nil {
		log.Fatalf("Failed map %v: ", err)
	}
	res := service.faqRepository.UpdateFaq(faq)
	return res
}

func (service *faqService) Delete(b entity.Faq) {
	service.faqRepository.DeleteFaq(b)
}
