import AdminCategories from './components/admin/categories/categories';
// import AdminCategoryDetail from './components/admin/categories/category_detail';
import AdminCategoryForm from './components/admin/categories/category_form';

import AdminDocuments from './components/admin/documents/documents';
import AdminDocumentForm from './components/admin/documents/document_form';

import AdminUsers from './components/admin/users/users';
import AdminUserForm from './components/admin/users/user_form';

import Dashboard from './components/dashboard/dashboard';
import CategoryDocuments from './components/dashboard/category_documents';

import Login from './components/base/auth/login';

import Admin from './components/admin/admin';
import UI from './components/dashboard/index';

export const routes = [
  // {
  //   path: '/admin',
  //   name: 'Admin',
  //   component: Admin,
  //   meta: {
  //     auth: true
  //   }
  // },
  {
    path: '/',
    name: 'UI',
    component: Dashboard,
    meta: {
      auth: false
    }
  },
  {
    path: '/dashboard',
    name: 'Dashboard',
    component: Dashboard,
    meta: {
      auth: false
    }
  },
  {
    path: '/category/:id',
    name: 'CategoryDocuments',
    component: CategoryDocuments,
    meta: {
      auth: false
    }
  },

    /** Маршруты авторизации **/
  {
    path: '/admin/login',
    name: 'Login',
    component: Login,
    meta: {
      auth: false
    }
  },
  {
    path: '/admin/categories',
    name: 'AdminCategories',
    component: AdminCategories,
    meta: {
      auth: true
    }
  },

  {
    path: '/admin/categories/create',
    name: 'AdminCategoryForm',
    component: AdminCategoryForm,
    meta: {
      auth: true
    }
  },

  {
    path: '/admin/categories/:id',
    name: 'AdminCategoryForm',
    component: AdminCategoryForm,
    meta: {
      auth: true
    }
  },

    /** Документы в админке */
  {
    path: '/admin/documents',
    name: 'AdminDocuments',
    component: AdminDocuments,
    meta: {
      auth: true
    }
  },

  {
    path: '/admin/documents/create',
    name: 'AdminDocumentForm',
    component: AdminDocumentForm,
    meta: {
      auth: true
    }
  },

  {
    path: '/admin/documents/:id',
    name: 'AdminDocumentForm',
    component: AdminDocumentForm,
    meta: {
      auth: true
    }
  },

  /** Пользователи в админке */
  {
    path: '/admin/users',
    name: 'AdminUsers',
    component: AdminUsers,
    meta: {
      auth: true
    }
  },

  {
    path: '/admin/users/create',
    name: 'AdminUserForm',
    component: AdminUserForm,
    meta: {
      auth: true
    }
  },

  {
    path: '/admin/users/:id',
    name: 'AdminUserForm',
    component: AdminUserForm,
    meta: {
      auth: true
    }
  }
];