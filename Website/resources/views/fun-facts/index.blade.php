@extends('layouts.admin')

@section('content')
    <style>
        .sortable-ghost {
            opacity: 0.5;
            background: #e9ecef;
        }
        .drag-handle {
            cursor: move;
            opacity: 0.7;
            transition: opacity 0.2s;
        }
        .drag-handle:hover {
            opacity: 1;
        }
        #sortable-facts tr {
            transition: transform 0.2s, box-shadow 0.2s;
        }
        #sortable-facts tr.sortable-ghost {
            transform: scale(1.02);
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
    </style>
<div class="container-fluid px-4" id="fun-facts-app">
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="mt-4">Fun Facts</h1>
        <button class="btn btn-primary" @click="showAddForm = !showAddForm">
            <i class="fas fa-plus me-1"></i> Add New Fact
        </button>
    </div>
    
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Fun Facts</li>
    </ol>

    <!-- Add New Fact Form -->
    <div class="card mb-4" v-if="showAddForm">
        <div class="card-header">
            <i class="fas fa-plus me-1"></i>
            Add New Fun Fact
        </div>
        <div class="card-body">
            <form @submit.prevent="addFact">
                <div class="mb-3">
                    <label for="newFact" class="form-label">Fun Fact</label>
                    <textarea class="form-control" id="newFact" rows="2" v-model="newFact" required></textarea>
                </div>
                <div class="d-flex justify-content-end gap-2">
                    <button type="button" class="btn btn-outline-secondary" @click="showAddForm = false">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-primary" :disabled="isLoading">
                        <span v-if="isLoading" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        <span v-else>Add Fact</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Facts List -->
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-lightbulb me-1"></i>
            Manage Fun Facts
        </div>
        <div class="card-body">
            <div v-if="facts.length === 0" class="text-center py-4">
                <i class="fas fa-lightbulb fa-3x text-muted mb-3"></i>
                <p class="h5 text-muted">No fun facts added yet</p>
                <p class="text-muted">Click the "Add New Fact" button to get started</p>
            </div>
            
            <div v-else class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th style="width: 40px;">#</th>
                            <th>Fact</th>
                            <th style="width: 100px;">Status</th>
                            <th style="width: 120px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="sortable-facts">
                        <tr v-for="(fact, index) in facts" :key="fact.id" class="align-middle" :data-id="fact.id">
                            <td class="drag-handle" style="cursor: move;">
                                <i class="fas fa-grip-vertical"></i>
                            </td>
                            <td>
                                <div v-if="editingId === fact.id">
                                    <input type="text" class="form-control form-control-sm" v-model="editingText" @keyup.enter="saveEdit(fact)">
                                </div>
                                <div v-else>
                                    @{{ fact.fact }}
                                </div>
                            </td>
                            <td>
                                <span class="badge" :class="fact.is_visible ? 'bg-success' : 'bg-secondary'" @click="toggleVisibility(fact)" style="cursor: pointer;">
                                    @{{ fact.is_visible ? 'Visible' : 'Hidden' }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm" v-if="editingId !== fact.id">
                                    <button class="btn btn-outline-primary" @click="startEditing(fact)" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-outline-danger" @click="deleteFact(fact)" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                                <div v-else>
                                    <button class="btn btn-sm btn-success me-1" @click="saveEdit(fact)">
                                        <i class="fas fa-check"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-secondary" @click="cancelEdit">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .sortable-ghost {
        opacity: 0.5;
        background: #f8f9fa;
    }
</style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue@3.3.4/dist/vue.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        // Make Sortable available globally
        window.Sortable = Sortable;
        
        const { createApp, ref, onMounted, nextTick } = Vue;
    
    createApp({
        setup() {
            const facts = ref([]);
            const showAddForm = ref(false);
            const newFact = ref('');
            const isLoading = ref(false);
            const editingId = ref(null);
            const editingText = ref('');
            let sortable = null;
            
            onMounted(() => {
                loadFacts().then(() => {
                    // Use nextTick to ensure the DOM is updated
                    nextTick(() => {
                        const sortableElement = document.getElementById('sortable-facts');
                        if (sortableElement) {
                            sortable = new window.Sortable(sortableElement, {
                                animation: 150,
                                handle: '.drag-handle',
                                ghostClass: 'sortable-ghost',
                                onEnd: onSort
                            });
                        }
                    });
                });
            });
            
            axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            const loadFacts = async () => {
                try {
                    const response = await axios.get('{{ route('fun-facts.index') }}');
                    facts.value = response.data;
                    return Promise.resolve();
                } catch (error) {
                    console.error('Error loading facts:', error);
                    if (error.response && error.response.status === 401) {
                        window.location.href = '/login';
                    } else {
                        alert('Failed to load facts. Please try again.');
                    }
                    return Promise.reject(error);
                }
            };
            
            // Add new fact
            const addFact = async () => {
                if (!newFact.value.trim()) return;
                
                isLoading.value = true;
                try {
                    const response = await axios.post('{{ route('fun-facts.store') }}', {
                        fact: newFact.value.trim(),
                        is_visible: true,
                        _method: 'POST'
                    });
                    
                    facts.value.push(response.data);
                    newFact.value = '';
                    showAddForm.value = false;
                    showToast('Fact added successfully!');
                } catch (error) {
                    console.error('Error adding fact:', error);
                    if (error.response && error.response.status === 401) {
                        window.location.href = '/login';
                    } else {
                        alert('Failed to add fact. Please try again.');
                    }
                } finally {
                    isLoading.value = false;
                }
            };
            
            // Start editing a fact
            const startEditing = (fact) => {
                editingId.value = fact.id;
                editingText.value = fact.fact;
            };
            
            // Save edited fact
            const saveEdit = async (fact) => {
                if (!editingText.value.trim()) return;
                
                try {
                    await axios.post(`/fun-facts/${fact.id}`, {
                        fact: editingText.value.trim(),
                        _method: 'PUT'
                    });
                    
                    const index = facts.value.findIndex(f => f.id === fact.id);
                    if (index !== -1) {
                        facts.value[index].fact = editingText.value.trim();
                    }
                    
                    cancelEdit();
                    showToast('Fact updated successfully!');
                } catch (error) {
                    console.error('Error updating fact:', error);
                    if (error.response && error.response.status === 401) {
                        window.location.href = '/login';
                    } else {
                        alert('Failed to update fact. Please try again.');
                    }
                }
            };
            
            // Cancel editing
            const cancelEdit = () => {
                editingId.value = null;
                editingText.value = '';
            };
            
            // Toggle fact visibility
            const toggleVisibility = async (fact) => {
                try {
                    const response = await axios.post(`/fun-facts/${fact.id}/toggle-visibility`);
                    fact.is_visible = response.data.data.is_visible;
                    showToast('Visibility updated!');
                } catch (error) {
                    console.error('Error toggling visibility:', error);
                    if (error.response && error.response.status === 401) {
                        window.location.href = '/login';
                    } else {
                        alert('Failed to update visibility. Please try again.');
                    }
                }
            };
            
            // Delete fact
            const deleteFact = async (fact) => {
                if (!confirm('Are you sure you want to delete this fact?')) return;
                
                try {
                    await axios.post(`/fun-facts/${fact.id}`, {
                        _method: 'DELETE'
                    });
                    facts.value = facts.value.filter(f => f.id !== fact.id);
                    showToast('Fact deleted successfully!');
                } catch (error) {
                    console.error('Error deleting fact:', error);
                    if (error.response && error.response.status === 401) {
                        window.location.href = '/login';
                    } else {
                        alert('Failed to delete fact. Please try again.');
                    }
                }
            };
            
            // Handle sort end
            const onSort = async () => {
                const order = [];
                const items = document.querySelectorAll('#sortable-facts > tr');
                items.forEach(item => {
                    order.push(parseInt(item.getAttribute('data-id')));
                });
                
                try {
                    await axios.post('{{ route('fun-facts.reorder') }}', {
                        order: order
                    });
                    // Update the local order without reloading the page
                    const newOrder = [];
                    order.forEach(id => {
                        const fact = facts.value.find(f => f.id === id);
                        if (fact) newOrder.push(fact);
                    });
                    facts.value = newOrder;
                    showToast('Order updated!');
                } catch (error) {
                    console.error('Error updating order:', error);
                    if (error.response && error.response.status === 401) {
                        window.location.href = '/login';
                    } else {
                        alert('Failed to update order. Please try again.');
                        loadFacts(); // Reload to restore original order
                    }
                }
            };
            
            // Show toast notification
            const showToast = (message) => {
                // You can replace this with your preferred toast implementation
                const toast = document.createElement('div');
                toast.className = 'position-fixed bottom-0 end-0 m-3 p-3 bg-success text-white rounded shadow';
                toast.style.zIndex = '1100';
                toast.textContent = message;
                document.body.appendChild(toast);
                
                setTimeout(() => {
                    toast.remove();
                }, 3000);
            };
            
            return {
                facts,
                showAddForm,
                newFact,
                isLoading,
                editingId,
                editingText,
                addFact,
                startEditing,
                saveEdit,
                cancelEdit,
                toggleVisibility,
                deleteFact,
                onSort
            };
        }
    }).mount('#fun-facts-app');
</script>
@endpush
@endsection
