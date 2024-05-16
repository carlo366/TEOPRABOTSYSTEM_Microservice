package entity

import (
	"gorm.io/gorm"
)

type Imagep struct {
	gorm.Model
	ID        uint64 `gorm:"primary_key:auto_increment"` // set primary key dan auto increment untuk kolom id
	ProductID uint   `gorm:"type:int" json:"product_id" validate:"required"`
	Image     string `gorm:"type:varchar(255)" json:"image" validate:"required,oneof=jpg jpeg png"`
}
