package repository

import (
	"github.com/carlo366/microservices-go/backend/imagep_service/entity"
	"gorm.io/gorm"
)

type ImagepRepository interface {
	InsertImagep(imagep entity.Imagep) entity.Imagep
	UpdateImagep(imagep entity.Imagep) entity.Imagep
	All() []entity.Imagep
	FindByID(imagepID uint64) entity.Imagep
	DeleteImagep(imagep entity.Imagep)
}

type imagepConnection struct {
	connection *gorm.DB
}

func NewImagepRepository(db *gorm.DB) ImagepRepository {
	return &imagepConnection{
		connection: db,
	}
}

func (db *imagepConnection) InsertImagep(imagep entity.Imagep) entity.Imagep {
	db.connection.Save(&imagep)
	return imagep
}

func (db *imagepConnection) UpdateImagep(imagep entity.Imagep) entity.Imagep {
	db.connection.Save(&imagep)
	return imagep
}

func (db *imagepConnection) All() []entity.Imagep {
	var imageps []entity.Imagep
	db.connection.Find(&imageps)
	return imageps
}

func (db *imagepConnection) FindByID(imagepID uint64) entity.Imagep {
	var imagep entity.Imagep
	db.connection.Find(&imagep, imagepID)
	return imagep
}

func (db *imagepConnection) DeleteImagep(imagep entity.Imagep) {
	db.connection.Delete(&imagep)
}
