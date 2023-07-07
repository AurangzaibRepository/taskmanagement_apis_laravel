import React from 'react';
import { InertiaLink, usePage } from '@inertiajs/inertia-react';
import DefaultLayout from '@/Layouts/DefaultLayout';
import Table from '@/Components/Table';

function Index() {
  const { teams } = usePage().props;
  const headerList = ['No', 'Code', 'Name', ''];

  return (
    <DefaultLayout>
      <div>
        <div className="container mx-auto">
          <h1 className="mb-8 font-bold bg-white" id="page-title">
            Teams
          </h1>
          <div className="flex items-center justify-end mb-4">
            <InertiaLink
              className="px-6 py-2 text-white bg-green-500 rounded-md focus:outline-none"
              href={window.route('teams.create')}
            >
              Create Team
            </InertiaLink>
          </div>
          <div className="dv-table overflow-x-auto bg-white rounded shadow">
            <Table headers={headerList} data={teams} />
          </div>
        </div>
      </div>
    </DefaultLayout>
  );
}

export default Index;
