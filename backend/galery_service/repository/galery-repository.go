package repository

import (
	"github.com/carlo366/microservices-go/backend/galery_service/entity"
	"gorm.io/gorm"
)

type GaleryRepository interface {
	InsertGalery(galery entity.Galery) entity.Galery
	UpdateGalery(galery entity.Galery) entity.Galery
	All() []entity.Galery
	FindByID(galeryID uint64) entity.Galery
	DeleteGalery(galery entity.Galery)
}

type galeryConnection struct {
	connection *gorm.DB
}

func NewGaleryRepository(db *gorm.DB) GaleryRepository {
	return &galeryConnection{
		connection: db,
	}
}

func (db *galeryConnection) InsertGalery(galery entity.Galery) entity.Galery {
	db.connection.Save(&galery)
	return galery
}

func (db *galeryConnection) UpdateGalery(galery entity.Galery) entity.Galery {
	db.connection.Save(&galery)
	return galery
}

func (db *galeryConnection) All() []entity.Galery {
	var categories []entity.Galery
	db.connection.Find(&categories)
	return categories
}

func (db *galeryConnection) FindByID(galeryID uint64) entity.Galery {
	var galery entity.Galery
	db.connection.Find(&galery, galeryID)
	return galery
}

func (db *galeryConnection) DeleteGalery(galery entity.Galery) {
	db.connection.Delete(&galery)
}
