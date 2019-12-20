import AdminCategories from './components/admin/categories/categories';
// import AdminCategoryDetail from './components/admin/categories/category_detail';
import AdminCategoryForm from './components/admin/categories/category_form';

import AdminDocuments from './components/admin/documents/documents';
import AdminDocumentForm from './components/admin/documents/document_form';

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
  },

    /** Документы в админке */
  {
    path: '/admin/documents',
    name: 'AdminDocuments',
    component: AdminDocuments
  },

  {
    path: '/admin/documents/create',
    name: 'AdminDocumentForm',
    component: AdminDocumentForm
  },

  {
    path: '/admin/documents/:id',
    name: 'AdminDocumentForm',
    component: AdminDocumentForm
  }
];