import AdminCategories from './components/admin/categories/categories';
// import AdminCategoryDetail from './components/admin/categories/category_detail';
import AdminCategoryForm from './components/admin/categories/category_form';

import AdminDocuments from './components/admin/documents/documents';
import AdminDocumentForm from './components/admin/documents/document_form';

import AdminUsers from './components/admin/users/users';
import AdminUserForm from './components/admin/users/user_form';

import Login from './components/base/auth/login';

export const routes = [
    /** Маршруты авторизации **/
  {
    path: '/admin/login',
    name: 'Login',
    component: Login,
    meta: {
      auth: undefined
    }
  },
  {
    path: '/admin/categories',
    name: 'AdminCategories',
    component: AdminCategories,
    meta: {
      auth: undefined
    }
  },

  {
    path: '/admin/categories/create',
    name: 'AdminCategoryForm',
    component: AdminCategoryForm,
    meta: {
      auth: undefined
    }
  },

  {
    path: '/admin/categories/:id',
    name: 'AdminCategoryForm',
    component: AdminCategoryForm,
    meta: {
      auth: undefined
    }
  },

    /** Документы в админке */
  {
    path: '/admin/documents',
    name: 'AdminDocuments',
    component: AdminDocuments,
    meta: {
      auth: undefined
    }
  },

  {
    path: '/admin/documents/create',
    name: 'AdminDocumentForm',
    component: AdminDocumentForm,
    meta: {
      auth: undefined
    }
  },

  {
    path: '/admin/documents/:id',
    name: 'AdminDocumentForm',
    component: AdminDocumentForm,
    meta: {
      auth: undefined
    }
  },

  /** Пользователи в админке */
  {
    path: '/admin/users',
    name: 'AdminUsers',
    component: AdminUsers,
    meta: {
      auth: undefined
    }
  },

  {
    path: '/admin/users/create',
    name: 'AdminUserForm',
    component: AdminUserForm,
    meta: {
      auth: undefined
    }
  },

  {
    path: '/admin/users/:id',
    name: 'AdminUserForm',
    component: AdminUserForm,
    meta: {
      auth: undefined
    }
  }
];