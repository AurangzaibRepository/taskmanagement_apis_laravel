import React from 'react';
import DefaultLayout from '@/Layouts/DefaultLayout';

function Index() {
  return (
    <DefaultLayout>
      <div className="container mx-auto">
        <h1 className="mb-8 font-bold bg-white" id="page-title">
          Projects
        </h1>
      </div>
    </DefaultLayout>
  );
}

export default Index;
