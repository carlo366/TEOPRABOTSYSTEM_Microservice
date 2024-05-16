package dto

type FaqUpdateDTO struct {
	ID          uint64 `json:"id" form:"id" binding:"required"`
	Name        string `gorm:"type:varchar(255)" json:"name" validate:"required,min=3,max=255"`
	Description string `gorm:"type:varchar(255)" json:"description" validate:"required,min=3,max=255"`
}

type FaqCreateDTO struct {
	Name        string `gorm:"type:varchar(255)" json:"name" validate:"required,min=3,max=255"`
	Description string `gorm:"type:varchar(255)" json:"description" validate:"required,min=3,max=255"`
}
