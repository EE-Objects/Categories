<?php

namespace EeObjects;

use EeObjects\Categories\Fields;
use ExpressionEngine\Model\Category\Category as CategoryModel;

class Categories
{
    protected $fields = null;

    /**
     * Returns the Fields object
     * @return Fields
     */
    protected function getFields()
    {
        if (is_null($this->fields)) {
            $this->fields = new Fields();
        }

        return $this->fields;
    }

    /**
     * Returns the EE Category
     * @param false $cat_id
     * @return Categories\Category|null
     */
    public function getCategory($cat_id = false): ?Categories\Category
    {
        $category = ee('Model')->get('Category', $cat_id)
            ->first();

        if ($category instanceof CategoryModel) {
            return $this->buildCategoryObj($category);
        }

        return null;
    }

    /**
     * @param array $where
     * @return Members\Member|null
     */
    public function getWhere(array $where)
    {
        $category = ee('Model')->get('Category');

        foreach ($where as $key => $value) {
            $category->filter($key, $value);
        }

        $category = $category->first();

        if ($category instanceof CategoryModel) {
            return $this->buildCategoryObj($category);
        }

        return null;
    }

    /**
     * @param MemberModel $member
     * @return Members\Member
     */
    protected function buildCategoryObj(CategoryModel $category)
    {
        $obj = new Categories\Category($category);
        $obj->setFields($this->getFields());

        return $obj;
    }

    /**
     * @param $group_id
     * @return Categories\Category
     */
    public function getBlankCategory($group_id): Categories\Category
    {
        $obj = new Categories\Category();
        $obj->setRoleId($group_id);

        return $obj->setFields($this->getFields());
    }
}
