<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import Pagination from '@/Components/Pagination.vue';
import AppLayout from '@/Layouts/AppLayout.vue';

defineProps({
    title: String,
});

const orders = ref({ data: [], links: [] });
const filters = ref({ customer: '', payment_status: '', order_status: '' });

const fetchOrders = async () => {
    const response = await axios.get('/orders', { params: filters.value });
    orders.value = response.data;
    console.log(orders.value); // Log the fetched orders
};



const editOrder = (id) => {
    console.log(`Edit order with ID: ${id}`);
};

const copyOrder = (id) => {
    console.log(`Copy order with ID: ${id}`);
};

const deleteOrder = (id) => {
    console.log(`Delete order with ID: ${id}`);
};

onMounted(fetchOrders);
</script>

<template>
    <AppLayout title="Orders">
        <div class="orders-page">
            <div class="filters">
                <input type="text" placeholder="Search by customer" v-model="filters.customer" @input="fetchOrders" class="input-field" />
                <select v-model="filters.payment_status" @change="fetchOrders" class="select-field">
                    <option value="">Payment Status</option>
                    <option value="Paid">Paid</option>
                    <option value="Pending">Pending</option>
                </select>
                <select v-model="filters.order_status" @change="fetchOrders" class="select-field">
                    <option value="">Order Status</option>
                    <option value="Ready">Ready</option>
                    <option value="Received">Received</option>
                </select>
            </div>

            <table class="orders-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Order Number</th>
                        <th>Order Date</th>
                        <th>Customer Name</th>
                        <th>Payment Status</th>
                        <th>Order Status</th>
                        <th>Total</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="order in orders.data" :key="order.id">
                        <td>{{ order.id }}</td>
                        <td>{{ order.order_number }}</td>
                        <td>{{ order.order_date }}</td>
                        <td>{{ order.customer_name }}</td>
                        <td :class="order.payment_status === 'Paid' ? 'status-paid' : 'status-pending'">
                            {{ order.payment_status }}
                        </td>
                        <td :class="order.order_status === 'Ready' ? 'status-ready' : 'status-received'">
                            {{ order.order_status }}
                        </td>
                        <td>{{ order.total }}</td>
                        <td>{{ order.created_at }}</td>
                        <td>{{ order.updated_at }}</td>
                        <td>
                            <button class="btn btn-edit" @click="editOrder(order.id)">Edit</button>
                            <button class="btn btn-copy" @click="copyOrder(order.id)">Copy</button>
                            <button class="btn btn-delete" @click="deleteOrder(order.id)">Delete</button>
                        </td>
                    </tr>
                </tbody>
            </table>

            <pagination :links="orders.links" @navigate="fetchOrders" />
        </div>
    </AppLayout>
</template>

<style scoped>
.orders-page {
    display: flex;
    flex-direction: column;
    font-family: 'Roboto', sans-serif;
    padding: 20px;
    background-color: #f9f9f9;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.filters {
    display: flex;
    gap: 15px;
    margin-bottom: 20px;
    align-items: center;
}

.input-field {
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    width: 200px;
    font-size: 14px;
}

.select-field {
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 14px;
}

.orders-table {
    width: 100%;
    border-collapse: collapse;
    background-color: white;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.orders-table th {
    background-color: #007bff;
    color: white;
    text-align: left;
    padding: 12px;
    font-size: 14px;
}

.orders-table td {
    padding: 12px;
    border: 1px solid #ddd;
    font-size: 14px;
}

.status-paid {
    color: #28a745;
    font-weight: bold;
}

.status-pending {
    color: #ffc107;
    font-weight: bold;
}

.status-ready {
    color: #17a2b8;
    font-weight: bold;
}

.status-received {
    color: #6f42c1;
    font-weight: bold;
}

.btn {
    padding: 8px 12px;
    border: none;
    border-radius: 4px;
    font-size: 14px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.btn-edit {
    background-color: #007bff;
    color: white;
}

.btn-edit:hover {
    background-color: #0056b3;
}

.btn-copy {
    background-color: #28a745;
    color: white;
}

.btn-copy:hover {
    background-color: #1e7e34;
}

.btn-delete {
    background-color: #dc3545;
    color: white;
}

.btn-delete:hover {
    background-color: #c82333;
}
</style>