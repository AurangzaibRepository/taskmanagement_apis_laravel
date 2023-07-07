import React from 'react';
import { InertiaLink } from '@inertiajs/inertia-react';

function SideLayout() {
  return (
    <div id="dv-side-layout" className="bg-white">
      <ul>
        <li>
          <InertiaLink href="/">Dashboard</InertiaLink>
        </li>
        <li>
          <InertiaLink href="/teams">Teams</InertiaLink>
        </li>
        <li>
          <InertiaLink href="/users">Users</InertiaLink>
        </li>
        <li>
          <InertiaLink href="/projects">Projects</InertiaLink>
        </li>
        <li>
          <InertiaLink href="/tasks">Tasks</InertiaLink>
        </li>
      </ul>
    </div>
  );
}

export default SideLayout;
