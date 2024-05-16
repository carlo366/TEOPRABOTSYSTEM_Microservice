package entity

import "gorm.io/gorm"

type Product struct {
	gorm.Model
	ID          uint64  `gorm:"primary_key:auto_increment"`
	Name        string  `gorm:"type:varchar(255)" json:"name" validate:"required,min=3,max=255"`
	Description string  `gorm:"type:varchar(255)" json:"description" validate:"required,min=3,max=255"`
	Price       uint64  `gorm:"type:int" json:"price" validate:"required"`
	Quantity    uint64  `gorm:"type:int" json:"quantity" validate:"required"`
	CategoryID  uint64  `gorm:"type:int" json:"category_id" validate:"required"`
	Length      float64 `gorm:"type:decimal(10,2)" json:"length" validate:"required,gt=0"`         // Validasi: wajib, harus lebih besar dari 0
	Width       float64 `gorm:"type:decimal(10,2)" json:"width" validate:"required,gt=0"`          // Validasi: wajib, harus lebih besar dari 0
	Color       string  `gorm:'"type:varchar(100)" json:"color" validate:"required,min=3,max=100"` // Validasi: wajib, panjang minimum 3, maksimum 100
}
