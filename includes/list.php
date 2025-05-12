<?php
// WP_List_Table is not loaded automatically so we need to load it in our application
if (!class_exists('WP_List_Table')) {
    require_once(ABSPATH . 'wp-admin/includes/screen.php');
    require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
}

class File_Upload_Table extends WP_List_Table
{
    public function prepare_items()
    {
        $columns = $this->get_columns();
        $hidden = $this->get_hidden_columns();
        $sortable = $this->get_sortable_columns();

        $data = $this->table_data();
        usort($data, array($this, 'sort_data'));

        $perPage = 5;
        $currentPage = $this->get_pagenum();
        $totalItems = count($data);

        $this->set_pagination_args(array(
            'total_items' => $totalItems,
            'per_page' => $perPage
        ));

        $data = array_slice($data, (($currentPage - 1) * $perPage), $perPage);

        $this->_column_headers = array($columns, $hidden, $sortable);
        $this->items = $data;
    }

    public function get_columns()
    {
        $columns = array(
            'cb' => '<input type="checkbox" />', // Checkbox column
            'label' => 'Label',
            'uploaded_file' => 'Uploaded File',
            'last_updated' => 'Last Updated',
            'actions' => 'Actions',
        );

        return $columns;
    }

    public function get_hidden_columns()
    {
        return array();
    }

    public function get_sortable_columns()
    {
        return array('label' => array('label', false));
    }

    private function table_data()
    {
        return array(
            array(
                'id' => 1,
                'label' => 'The title of a flipbook',
                'uploaded_file' => 'http://tangible-uploads.local/wp-content/uploads/tangible-embeddable-uploads/Flip%20book/Geo%20Apps%20Stacks%20Flipbook.html',
                'last_updated' => '2024-05-17 9:47 AM',
                'actions' => '<button data-micromodal-trigger="modal-1" class="btn rename" >Rename</button> <button data-micromodal-trigger="modal-1" class="btn replace">Replace</button> <button data-micromodal-trigger="modal-1" class="btn delete">Delete</button>'
            ),
            array(
                'id' => 2,
                'label' => 'The title of another flipbook',
                'uploaded_file' => 'http://tangible-uploads.local/wp-content/uploads/tangible-embeddable-uploads/Flip%20book/Geo%20Apps%20Stacks%20Flipbook.html',
                'last_updated' => '2024-05-17 9:47 AM',
                'actions' => '<button data-micromodal-trigger="modal-1" class="btn rename">Rename</button> <button data-micromodal-trigger="modal-1" class="btn replace">Replace</button> <button data-micromodal-trigger="modal-1" class="btn delete">Delete</button>'
            ),
        );
    }

    public function column_default($item, $column_name)
    {
        switch ($column_name) {
            case 'label':
            case 'uploaded_file':
            case 'last_updated':
            case 'actions':
                return $item[$column_name];

            default:
                return print_r($item, true);
        }
    }

    /**
     * Renders the checkbox in the first column
     */
    public function column_cb($item)
    {
        return sprintf(
            '<input type="checkbox" name="file_ids[]" value="%s" />',
            $item['id']
        );
    }

    private function sort_data($a, $b)
    {
        $orderby = $_GET['orderby'] ?? 'label';
        $order = $_GET['order'] ?? 'asc';

        $result = strcmp($a[$orderby], $b[$orderby]);

        return ($order === 'asc') ? $result : -$result;
    }
}
