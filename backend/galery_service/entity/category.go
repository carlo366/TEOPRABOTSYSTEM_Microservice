package entity

import (
	"gorm.io/gorm"
)

type Galery struct {
	gorm.Model
	ID    uint64 `gorm:"primary_key:auto_increment"` // set primary key and auto increment untuk kolom id
	Name  string `gorm:"type:varchar(255);unique" json:"name" validate:"required,min=3,max=255"`
	Image string `gorm:"type:varchar(255)" json:"image" validate:"required,oneof=jpg jpeg png"`
}
