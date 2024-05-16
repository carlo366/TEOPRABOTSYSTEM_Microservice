package dto

type CategoryUpdateDTO struct {
	ID    uint64 `json:"id" form:"id" binding:"required"`
	Name  string `json:"name" form:"name" binding:"required,min=3,max=255"`
	Image string `gorm:"type:varchar(255)" json:"image" validate:"required,oneof=jpg jpeg png"`
}

type CategoryCreateDTO struct {
	Name  string `json:"name" form:"name" binding:"required,min=3,max=255"`
	Image string `gorm:"type:varchar(255)" json:"image" validate:"required,oneof=jpg jpeg png"`
}
