<?php 

class Category extends BaseModel
{
    protected $table = 'categories';

    // Lấy tất cả danh mục, có thể sắp xếp theo ID giảm dần
    public function getAll()
    {
        return $this->select('*', '1 = 1 ORDER BY id DESC');
    }

    // Tìm danh mục theo ID
    public function getById($id)
    {
        return $this->find('*', 'id = :id', ['id' => $id]);
    }

    // Thêm danh mục mới
    public function add($data)
    {
        return $this->insert($data);
    }

    // Cập nhật danh mục theo ID
    public function updateById($id, $data)
    {
        return $this->update($data, 'id = :id', ['id' => $id]);
    }

    // Xóa danh mục theo ID
    public function deleteById($id)
    {
        return $this->delete('id = :id', ['id' => $id]);
    }
}
