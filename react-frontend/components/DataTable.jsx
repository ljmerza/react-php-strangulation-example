import React, { useState, useMemo } from 'react';
import styles from './DataTable.module.css';

export default function DataTable({
  data = [],
  columns = [],
  sortable = true,
  paginated = true,
  pageSize = 10,
  onRowClick,
  emptyMessage = "No data available"
}) {
  const [sortConfig, setSortConfig] = useState({ key: null, direction: 'asc' });
  const [currentPage, setCurrentPage] = useState(1);

  // Sorting logic
  const sortedData = useMemo(() => {
    if (!sortConfig.key) return data;

    return [...data].sort((a, b) => {
      const aVal = a[sortConfig.key];
      const bVal = b[sortConfig.key];

      if (aVal < bVal) return sortConfig.direction === 'asc' ? -1 : 1;
      if (aVal > bVal) return sortConfig.direction === 'asc' ? 1 : -1;
      return 0;
    });
  }, [data, sortConfig]);

  // Pagination logic
  const paginatedData = useMemo(() => {
    if (!paginated) return sortedData;

    const startIndex = (currentPage - 1) * pageSize;
    return sortedData.slice(startIndex, startIndex + pageSize);
  }, [sortedData, currentPage, pageSize, paginated]);

  const totalPages = Math.ceil(sortedData.length / pageSize);

  const handleSort = (columnKey) => {
    if (!sortable) return;

    setSortConfig(prev => ({
      key: columnKey,
      direction: prev.key === columnKey && prev.direction === 'asc' ? 'desc' : 'asc'
    }));
  };

  const getSortIcon = (columnKey) => {
    if (sortConfig.key !== columnKey) return '↕️';
    return sortConfig.direction === 'asc' ? '↑' : '↓';
  };

  if (data.length === 0) {
    return <div className={styles.empty}>{emptyMessage}</div>;
  }

  return (
    <div className={styles.table}>
      <table>
        <thead>
          <tr>
            {columns.map((column, index) => {
              if (!column) return null; // Skip invalid columns

              return (
                <th
                  key={column.key || index}
                  className={sortable ? styles.sortable : ''}
                  onClick={() => handleSort(column.key)}
                >
                  {column.label || column.key}
                  {sortable && (
                    <span className={styles.sortIcon}>
                      {getSortIcon(column.key)}
                    </span>
                  )}
                </th>
              );
            })}
          </tr>
        </thead>
        <tbody>
          {paginatedData.map((row, rowIndex) => (
            <tr
              key={rowIndex}
              className={onRowClick ? styles.clickable : ''}
              onClick={() => onRowClick?.(row, rowIndex)}
            >
              {columns.map((column, colIndex) => {
                if (!column) return null; // Skip invalid columns

                return (
                  <td key={column.key || colIndex}>
                    {column.render
                      ? column.render(row?.[column.key], row, rowIndex)
                      : row?.[column.key]
                    }
                  </td>
                );
              })}
            </tr>
          ))}
        </tbody>
      </table>

      {paginated && totalPages > 1 && (
        <div className={styles.pagination}>
          <button
            disabled={currentPage === 1}
            onClick={() => setCurrentPage(1)}
          >
            ⏮️
          </button>
          <button
            disabled={currentPage === 1}
            onClick={() => setCurrentPage(prev => prev - 1)}
          >
            ⬅️
          </button>

          <span className={styles.pageInfo}>
            Page {currentPage} of {totalPages} ({sortedData.length} total)
          </span>

          <button
            disabled={currentPage === totalPages}
            onClick={() => setCurrentPage(prev => prev + 1)}
          >
            ➡️
          </button>
          <button
            disabled={currentPage === totalPages}
            onClick={() => setCurrentPage(totalPages)}
          >
            ⏭️
          </button>
        </div>
      )}
    </div>
  );
}