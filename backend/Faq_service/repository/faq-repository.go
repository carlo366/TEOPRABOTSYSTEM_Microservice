package repository

import (
	"github.com/carlo366/microservices-go/backend/faq_service/entity"
	"gorm.io/gorm"
)

type FaqRepository interface {
	InsertFaq(faq entity.Faq) entity.Faq
	UpdateFaq(faq entity.Faq) entity.Faq
	All() []entity.Faq
	FindByID(faqID uint64) entity.Faq
	DeleteFaq(faq entity.Faq)
}

type faqConnection struct {
	connection *gorm.DB
}

func NewFaqRepository(db *gorm.DB) FaqRepository {
	return &faqConnection{
		connection: db,
	}
}

func (db *faqConnection) InsertFaq(faq entity.Faq) entity.Faq {
	db.connection.Save(&faq)
	return faq
}

func (db *faqConnection) UpdateFaq(faq entity.Faq) entity.Faq {
	db.connection.Save(&faq)
	return faq
}

func (db *faqConnection) All() []entity.Faq {
	var faqs []entity.Faq
	db.connection.Find(&faqs)
	return faqs
}

func (db *faqConnection) FindByID(faqID uint64) entity.Faq {
	var faq entity.Faq
	db.connection.Find(&faq, faqID)
	return faq
}

func (db *faqConnection) DeleteFaq(faq entity.Faq) {
	db.connection.Delete(&faq)
}
