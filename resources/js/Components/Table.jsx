import React from 'react';
import PropTypes from 'prop-types';
import { InertiaLink } from '@inertiajs/inertia-react';

function Table({ headers, data }) {
  return (
    <table className="w-full whitespace-nowrap">
      <thead className="text-white bg-gray-600">
        <tr className="font-bold text-left">
          {headers.map((item, index) => (
            <th className="px-6 pt-3 pb-3" key={index}>
              {item}
            </th>
          ))}
        </tr>
      </thead>
      <tbody>
        {data.map(item => (
          <tr key={item.id}>
            <td>{item.id}</td>
            <td>{item.code}</td>
            <td>{item.name}</td>
            <td>
              <InertiaLink className="px-4 py-2 text-sm text-white bg-blue-500 rounded">
                Edit
              </InertiaLink>
            </td>
          </tr>
        ))}
      </tbody>
    </table>
  );
}

Table.propTypes = {
  headers: PropTypes.instanceOf(Array).isRequired,
  data: PropTypes.instanceOf(Array).isRequired,
};

export default Table;
