/* eslint-disable no-undef */
export default {
  items: [
    {
      title: 'Dashboard',
      icon: 'mdi-view-dashboard',
      to: 'dashboard',
      type: 'link',
    },
    {
      title: 'Progetti',
      icon: 'mdi-account-group',
      to: 'project.index',
      type: 'link',
    },
    {
      title: 'Credenziali',
      icon: 'mdi-account-group',
      to: 'credential.index',
      type: 'link',
    },
    {
      title: 'Todo',
      icon: 'mdi-account-group',
      to: 'todo.index',
      type: 'link',
    },
    {
      title: 'Gruppo',
      icon: 'mdi-group',
      type: 'group',
      children: [
        {
          title: 'Progetti',
          icon: 'mdi-account-group',
          to: 'project.index',
          type: 'link',
        },
      ],
    },
  ],
}
