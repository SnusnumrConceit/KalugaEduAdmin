import AdminCategories from './components/admin/categories/categories';
// import AdminCategoryDetail from './components/admin/categories/category_detail';
import AdminCategoryForm from './components/admin/categories/category_form';

export const routes = [
  {
    path: '/admin/categories',
    name: 'AdminCategories',
    component: AdminCategories
  },

  {
    path: '/admin/categories/create',
    name: 'AdminCategoryForm',
    component: AdminCategoryForm
  },

  {
    path: '/admin/categories/:id',
    name: 'AdminCategoryForm',
    component: AdminCategoryForm
  }
];