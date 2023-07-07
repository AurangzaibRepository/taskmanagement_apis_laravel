import React from 'react';
import PropTypes from 'prop-types';
import Navbar from './Navbar';
import SideLayout from './SideLayout';

function DefaultLayout({ children }) {
  return (
    <div className="min-h-screen bg-gray-100">
      <Navbar />
      <div id="dv-main" className="flex">
        <SideLayout />
        <div id="dv-contents">{children}</div>
      </div>
    </div>
  );
}

DefaultLayout.propTypes = {
  children: PropTypes.node.isRequired,
};

export default DefaultLayout;
