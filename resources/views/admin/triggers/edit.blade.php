@extends('layouts.admin')

@section('header')
    <x-admin.header title="Edit Trigger" />
@endsection

@section('content')
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <div class="card card-primary">
        <form method="POST" action="{{ route('admin.triggers.update', $trigger->id) }}">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Enter trigger name" value="{{ old('name', $trigger->name) }}">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <input type="text" name="description" class="form-control @error('description') is-invalid @enderror" id="description" placeholder="Enter description" value="{{ old('description', $trigger->description) }}">
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Meet all the following conditions</label>
                    <div id="allConditions">
                        <!-- Conditions will be added here dynamically based on existing trigger -->
                    </div>
                    <button type="button" class="btn btn-secondary mt-2" onclick="addCondition('allConditions')">Add Condition</button>
                </div>
                <div class="form-group">
                    <label>Meet any of the following conditions</label>
                    <div id="anyConditions">
                        <!-- Conditions will be added here dynamically based on existing trigger -->
                    </div>
                    <button type="button" class="btn btn-secondary mt-2" onclick="addCondition('anyConditions')">Add Condition</button>
                </div>
                <div class="form-group">
                    <label>Perform these actions</label>
                    <div id="actions">
                        <!-- Actions will be added here dynamically based on existing trigger -->
                    </div>
                    <button type="button" class="btn btn-secondary mt-2" onclick="addAction('actions')">Add Action</button>
                </div>
                

                <div>
                    <button type="button" class="btn btn-primary" onclick="combineConditions(); this.form.submit();">Submit</button>
                    <a href="{{ route('admin.triggers.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </div>
            <input type="hidden" name="trigger_query" id="trigger_query" value="{{ $trigger->query }}">
        </form>
    </div>
    <script>
        const subjectOptions = [{
                text: 'Select a subject',
                value: ''
            },
            {
                text: 'User Name',
                value: 'user.name'
            },
            {
                text: 'User Email',
                value: 'user.email'
            },
            {
                text: 'Ticket Title',
                value: 'ticket.title'
            },
            {
                text: 'Ticket Message',
                value: 'ticket.message'
            },
        ];
    
        const conditionTypeOptionsMap = {
            'user.email': [{
                    text: 'is',
                    value: '='
                },
                {
                    text: 'contains',
                    value: 'LIKE'
                },
                {
                    text: 'not equals',
                    value: '!='
                },
                {
                    text: 'not like',
                    value: 'NOT LIKE'
                },
            ],
            'user.name': [{
                    text: 'is',
                    value: '='
                },
                {
                    text: 'contains',
                    value: 'LIKE'
                },
                {
                    text: 'not equals',
                    value: '!='
                },
                {
                    text: 'not like',
                    value: 'NOT LIKE'
                },
            ],
            'default': [{
                    text: 'is',
                    value: '='
                },
                {
                    text: 'contains',
                    value: 'LIKE'
                },
                {
                    text: 'not equals',
                    value: '!='
                },
                {
                    text: 'not like',
                    value: 'NOT LIKE'
                },
            ]
        };

        function addCondition(containerId, subject = '', operator = '', value = '') {
            const container = document.getElementById(containerId);
            const flexContainer = document.createElement('div');
            flexContainer.style.display = 'flex';
            flexContainer.style.gap = '10px';
    
            // Subject select
            const subjectSelect = document.createElement('select');
            subjectSelect.name = containerId + '[]';
            subjectSelect.className = 'form-control mt-2';
            subjectOptions.forEach(option => {
                const optionElement = document.createElement('option');
                optionElement.text = option.text;
                optionElement.value = option.value;
                if (option.value === subject) {
                    optionElement.selected = true;
                }
                subjectSelect.appendChild(optionElement);
            });
            flexContainer.appendChild(subjectSelect);
    
            // Condition type select
            const conditionTypeSelect = document.createElement('select');
            conditionTypeSelect.name = containerId + '[]';
            conditionTypeSelect.className = 'form-control mt-2';
            conditionTypeSelect.disabled = true;
            flexContainer.appendChild(conditionTypeSelect);
    
            // Enable and update condition type based on subject selection
            subjectSelect.addEventListener('change', function() {
                conditionTypeSelect.disabled = false;
                conditionTypeSelect.innerHTML = '';
    
                const conditionTypeOptions = conditionTypeOptionsMap[subjectSelect.value] || conditionTypeOptionsMap['default'];
                conditionTypeOptions.forEach(option => {
                    const optionElement = document.createElement('option');
                    optionElement.text = option.text;
                    optionElement.value = option.value;
                    if (option.value === operator) {
                        optionElement.selected = true;
                    }
                    conditionTypeSelect.appendChild(optionElement);
                });
            });
    
            // Value input
            const valueInput = document.createElement('input');
            valueInput.type = 'text';
            valueInput.name = containerId + '[]';
            valueInput.className = 'form-control mt-2';
            valueInput.placeholder = 'Enter value';
            valueInput.value = value;
            flexContainer.appendChild(valueInput);
    
            // Delete button
            const deleteButton = document.createElement('button');
            deleteButton.type = 'button';
            deleteButton.className = 'btn btn-danger mt-2';
            deleteButton.innerHTML = 'X';
            deleteButton.style.height = '38px';
            deleteButton.onclick = () => flexContainer.remove();
            flexContainer.appendChild(deleteButton);
    
            // Append flex container to main container
            container.appendChild(flexContainer);
        }
    
        const actionOptions = [{
                text: 'Select an action',
                value: ''
            },
            {
                text: 'Ticket: Assign to Agent',
                value: 'SET NEW.assigned_to = '
            },
            {
                text: 'Ticket: Change status',
                value: 'UPDATE tickets SET status = '
            },
        ];
    
        function addAction(containerId, action = '', value = '') {
            const container = document.getElementById(containerId);
            const flexContainer = document.createElement('div');
            flexContainer.style.display = 'flex';
            flexContainer.style.gap = '10px';
    
            // Action select
            const actionSelect = document.createElement('select');
            actionSelect.name = containerId + '[]';
            actionSelect.className = 'form-control mt-2';
            const valueInput = document.createElement('select');
            valueInput.name = containerId + '[]';
            valueInput.className = 'form-control mt-2';
    
            actionOptions.forEach(option => {
                const optionElement = document.createElement('option');
                optionElement.text = option.text;
                optionElement.value = option.value;
                if (option.value === action) {
                    optionElement.selected = true;
                }
                actionSelect.appendChild(optionElement);
            });
            flexContainer.appendChild(actionSelect);
            flexContainer.appendChild(valueInput);
    
            // Event listener for action selection
            actionSelect.addEventListener('change', function() {
                valueInput.innerHTML = '';
    
                const actionHandlers = {
                    'UPDATE tickets SET status = ': () => {
                        const statusOptions = [{
                                text: 'Open',
                                value: 'open'
                            },
                            {
                                text: 'Closed',
                                value: 'closed'
                            }
                        ];
                        statusOptions.forEach(option => {
                            const optionElement = document.createElement('option');
                            optionElement.text = option.text;
                            optionElement.value = option.value;
                            if (option.value === value) {
                                optionElement.selected = true;
                            }
                            valueInput.appendChild(optionElement);
                        });
                    },
                    'SET NEW.assigned_to = ': () => {
                        const agents = @json($agents); // Assuming $agents is passed from the backend
                        if (agents.length === 0) {
                            const optionElement = document.createElement('option');
                            optionElement.text = 'No agents available';
                            optionElement.value = '';
                            valueInput.appendChild(optionElement);
                        } else {
                            agents.forEach(agent => {
                                const optionElement = document.createElement('option');
                                optionElement.text = agent.name;
                                optionElement.value = agent.id;
                                if (agent.id == value) {
                                    optionElement.selected = true;
                                }
                                valueInput.appendChild(optionElement);
                            });
                        }
                    },
                    'default': () => {
                        const defaultOption = document.createElement('option');
                        defaultOption.text = 'Enter value';
                        defaultOption.value = '';
                        valueInput.appendChild(defaultOption);
                    }
                };
    
                const handler = Object.keys(actionHandlers).find(key => actionSelect.value.includes(key)) || 'default';
                actionHandlers[handler]();
            });
    
            // Delete button
            const deleteButton = document.createElement('button');
            deleteButton.type = 'button';
            deleteButton.className = 'btn btn-danger mt-2';
            deleteButton.innerHTML = 'X';
            deleteButton.style.height = '38px';
            deleteButton.onclick = () => flexContainer.remove();
            flexContainer.appendChild(deleteButton);
    
            // Append flex container to main container
            container.appendChild(flexContainer);
        }
    
        function combineConditions() {
            const allConditions = document.getElementById('allConditions').children;
            const anyConditions = document.getElementById('anyConditions').children;
            const actions = document.getElementById('actions').children;
    
            let query = `CREATE TRIGGER ${document.getElementById('name').value} BEFORE INSERT ON tickets FOR EACH ROW BEGIN `;
    
            let conditionsQuery = [];
            for (let condition of allConditions) {
                const subject = condition.children[0].value;
                const operator = condition.children[1].value;
                const value = condition.children[2].value;
                const tableAlias = subject.startsWith('user') ? 'users' : 'tickets';
                conditionsQuery.push(`(SELECT ${subject.split('.')[1]} FROM ${tableAlias} WHERE ${subject.split('.')[1]} ${operator} ${operator === 'LIKE' ? `'%${value}%'` : `'${value}'`})`);
            }
            if (conditionsQuery.length > 0) {
                query += `IF ${conditionsQuery.join(' AND ')} THEN `;
            }
    
            if (anyConditions.length > 0) {
                let anyConditionsQuery = [];
                for (let condition of anyConditions) {
                    const subject = condition.children[0].value;
                    const operator = condition.children[1].value;
                    const value = condition.children[2].value;
                    const tableAlias = subject.startsWith('user') ? 'users' : 'tickets';
                    anyConditionsQuery.push(`(SELECT ${subject.split('.')[1]} FROM ${tableAlias} WHERE ${subject.split('.')[1]} ${operator} '${value}')`);
                }
                if (conditionsQuery.length > 0) {
                    query += ' ELSE ';
                }
                query += `IF ${anyConditionsQuery.join(' OR ')} THEN `;
            }
    
            if (actions.length > 0) {
                for (let action of actions) {
                    const actionValue = action.children[0].value;
                    let actionQuery = actionValue;
                    for (let i = 1; i < action.children.length; i++) {
                        const paramValue = action.children[i].value;
                        actionQuery += `${paramValue} `;
                    }
                    query += actionQuery;
                }
            }
    
            query += '; END IF; END;'; // Ensure proper ending of the trigger statement
       
    
            // Set the hidden input value
            document.getElementById('trigger_query').value = query;
        }

        // Populate the existing conditions and actions on page load
        document.addEventListener('DOMContentLoaded', function() {
            const existingConditions = @json($trigger->conditions);
            const existingActions = @json($trigger->actions);
    
            // Populate allConditions
            existingConditions.all.forEach(condition => {
                addCondition('allConditions', condition.subject, condition.operator, condition.value);
            });
    
            // Populate anyConditions
            existingConditions.any.forEach(condition => {
                addCondition('anyConditions', condition.subject, condition.operator, condition.value);
            });
    
            // Populate actions
            existingActions.forEach(action => {
                addAction('actions', action.action, action.value);
            });
        });
    </script>
    
@endsection
