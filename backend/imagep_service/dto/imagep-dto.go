package dto

type ImagepUpdateDTO struct {
	ID        uint64 `json:"id" form:"id" binding:"required"`
	ProductID uint   `gorm:"type:int" json:"product_id" validate:"required"`
	Image     string `gorm:"type:varchar(255)" json:"image" validate:"required,oneof=jpg jpeg png"`
}

type ImagepCreateDTO struct {
	ProductID uint   `gorm:"type:int" json:"product_id" validate:"required"`
	Image     string `gorm:"type:varchar(255)" json:"image" validate:"required,oneof=jpg jpeg png"`
}
