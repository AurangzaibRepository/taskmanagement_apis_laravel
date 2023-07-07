import React from 'react';
import NavLink from '@/Components/NavLink';

function Navbar() {
  return (
    <nav className="bg-gray-600 border-b border-gray-100">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div className="flex justify-between h-16">
            <NavLink
                href={route('dashboard')}
                className="navbar-header"
            >
                Task Management
            </NavLink>
            </div>
        </div>
    </nav>
  );
}

export default Navbar;
