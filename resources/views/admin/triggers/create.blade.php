@extends('layouts.admin')

@section('header')
    <x-admin.header title="Create Trigger" />
@endsection

@section('content')
    <div class="card card-primary">
        <form method="POST" action="{{ route('admin.triggers.store') }}">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" class="form-control" id="name" placeholder="Enter trigger name">
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <input type="text" name="description" class="form-control" id="description"
                        placeholder="Enter description">
                </div>
                <div class="form-group">
                    <label>Meet all the following conditions</label>
                    <div id="allConditions">
                        <!-- Conditions will be added here -->
                    </div>
                    <button type="button" class="btn btn-secondary mt-2" onclick="addCondition('allConditions')">Add
                        Condition</button>
                </div>
                <div class="form-group">
                    <label>Meet any of the following conditions</label>
                    <div id="anyConditions">
                        <!-- Conditions will be added here -->
                    </div>
                    <button type="button" class="btn btn-secondary mt-2" onclick="addCondition('anyConditions')">Add
                        Condition</button>
                </div>
                <div class="form-group">
                    <label>Perform these actions</label>
                    <div id="actions">
                        <!-- Actions will be added here -->
                    </div>
                    <button type="button" class="btn btn-secondary mt-2" onclick="addAction('actions')">Add Action</button>
                </div>
                <div class="form-group">
                    <button type="button" class="btn btn-secondary" onclick="combineConditions()">Combine
                        Conditions</button>
                </div>

                <div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a href="{{ route('admin.triggers.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </div>
            <input type="hidden" name="trigger_query" id="trigger_query">
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
            {
                text: 'Ticket Status',
                value: 'ticket.status'
            },
            {
                text: 'Ticket Category',
                value: 'ticket.category'
            },
            {
                text: 'Ticket Priority',
                value: 'ticket.priority'
            },
            {
                text: 'Ticket Latitude',
                value: 'ticket.latitude'
            },
            {
                text: 'Ticket Longitude',
                value: 'ticket.longitude'
            },
            {
                text: 'Ticket Is Resolved',
                value: 'ticket.is_resolved'
            },
            {
                text: 'Ticket Is Locked',
                value: 'ticket.is_locked'
            },
            // Add more options as needed
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
                    value: '!= '
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
            'ticket.status': [{
                    text: 'is',
                    value: '='
                },
                {
                    text: 'not equals',
                    value: '!='
                },
            ],
            'ticket.category': [{
                    text: 'is',
                    value: '='
                },
                {
                    text: 'not equals',
                    value: '!='
                },
            ],
            'default': [{
                    text: 'Select a condition type',
                    value: ''
                },
                {
                    text: 'is',
                    value: '='
                },
                {
                    text: 'contains',
                    value: 'LIKE'
                },
                {
                    text: 'equals',
                    value: '='
                },
                {
                    text: 'not equals',
                    value: '!='
                },
                {
                    text: 'like',
                    value: 'LIKE'
                },
                {
                    text: 'not like',
                    value: 'NOT LIKE'
                },
            ]
        };

        function addCondition(containerId) {
            const container = document.getElementById(containerId);

            // Create a flex container for the subject, condition type, and value
            const flexContainer = document.createElement('div');
            flexContainer.style.display = 'flex';
            flexContainer.style.gap = '10px'; // Adjust the gap as needed

            // First input: Subject
            const subjectSelect = document.createElement('select');
            subjectSelect.name = containerId + '[]';
            subjectSelect.className = 'form-control mt-2';
            subjectOptions.forEach(option => {
                const optionElement = document.createElement('option');
                optionElement.text = option.text;
                optionElement.value = option.value;
                subjectSelect.appendChild(optionElement);
            });
            flexContainer.appendChild(subjectSelect);

            // Second input: Condition type
            const conditionTypeSelect = document.createElement('select');
            conditionTypeSelect.name = containerId + '[]';
            conditionTypeSelect.className = 'form-control mt-2';
            conditionTypeSelect.disabled = true; // Initially disable the condition type select
            flexContainer.appendChild(conditionTypeSelect);

            // Event listener to enable and update condition type based on subject selection
            subjectSelect.addEventListener('change', function() {
                conditionTypeSelect.disabled = false;
                conditionTypeSelect.innerHTML = ''; // Clear previous options

                const conditionTypeOptions = conditionTypeOptionsMap[subjectSelect.value] ||
                    conditionTypeOptionsMap['default'];
                conditionTypeOptions.forEach(option => {
                    const optionElement = document.createElement('option');
                    optionElement.text = option.text;
                    optionElement.value = option.value;
                    conditionTypeSelect.appendChild(optionElement);
                });
            });

            // Third input: Value
            const valueInput = document.createElement('input');
            valueInput.type = 'text';
            valueInput.name = containerId + '[]';
            valueInput.className = 'form-control mt-2';
            valueInput.placeholder = 'Enter value';
            flexContainer.appendChild(valueInput);

            // Add delete button
            const deleteButton = document.createElement('button');
            deleteButton.type = 'button';
            deleteButton.className = 'btn btn-danger mt-2';
            deleteButton.innerHTML = 'X';
            deleteButton.style.height = '38px';
            deleteButton.onclick = () => flexContainer.remove();
            flexContainer.appendChild(deleteButton);
            // Append the flex container to the main container
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
            // Add more options as needed
        ];

        function addAction(containerId) {
            const container = document.getElementById(containerId);

            // Create a flex container for the action and value
            const flexContainer = document.createElement('div');
            flexContainer.style.display = 'flex';
            flexContainer.style.gap = '10px'; // Adjust the gap as needed

            // First input: Action
            const actionSelect = document.createElement('select');
            actionSelect.name = containerId + '[]';
            actionSelect.className = 'form-control mt-2';
            const valueInput = document.createElement('select'); // Move valueInput declaration here
            valueInput.name = containerId + '[]';
            valueInput.className = 'form-control mt-2';

            actionOptions.forEach(option => {
                const optionElement = document.createElement('option');
                optionElement.text = option.text;
                optionElement.value = option.value;
                actionSelect.appendChild(optionElement);
            });
            flexContainer.appendChild(actionSelect);

            // Second input: Value
            flexContainer.appendChild(valueInput);

            actionSelect.addEventListener('change', function() {
                valueInput.innerHTML = ''; // Clear previous options

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
                            valueInput.appendChild(optionElement);
                        });
                    },
                    'SET NEW.assigned_to = ': () => {
                        const agents =
                        @json($agents); // Assuming $agents is passed from the backend
                        if (agents.length === 0) {
                            const optionElement = document.createElement('option');
                            optionElement.text = 'No agents available';
                            optionElement.value = '';
                            valueInput.appendChild(optionElement);
                        } else {
                            agents.forEach(agent => {
                                const optionElement = document.createElement('option');
                                optionElement.text = agent.name;
                                optionElement.value = agent.id; // Fix: Use agent.id directly
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

                const handler = Object.keys(actionHandlers).find(key => actionSelect.value.includes(key)) ||
                    'default';
                actionHandlers[handler]();
            });

            // Add delete button
            const deleteButton = document.createElement('button');
            deleteButton.type = 'button';
            deleteButton.className = 'btn btn-danger mt-2';
            deleteButton.innerHTML = 'X';
            deleteButton.style.height = '38px';
            deleteButton.onclick = () => flexContainer.remove();
            flexContainer.appendChild(deleteButton);
            // Append the flex container to the main container
            container.appendChild(flexContainer);
        }

        function combineConditions() {
            const allConditions = document.getElementById('allConditions').children;
            const anyConditions = document.getElementById('anyConditions').children;
            const actions = document.getElementById('actions').children;

            let query =
                `CREATE TRIGGER ${document.getElementById('name').value} BEFORE INSERT ON tickets FOR EACH ROW BEGIN `;

            let conditionsQuery = [];
            for (let condition of allConditions) {
                const subject = condition.children[0].value;
                const operator = condition.children[1].value;
                const value = condition.children[2].value;
                conditionsQuery.push(`IF NEW.${subject.split('.')[1]} ${operator} ${operator === 'LIKE' ? `'%${value}%'` : `'${value}'`}`);
            }
            if (conditionsQuery.length > 0) {
                query += conditionsQuery.join(' AND ');
            }

            if (anyConditions.length > 0) {
                if (conditionsQuery.length > 0) {
                    query += ' ELSE ';
                }
                let anyConditionsQuery = [];
                for (let condition of anyConditions) {
                    const subject = condition.children[0].value;
                    const operator = condition.children[1].value;
                    const value = condition.children[2].value;
                    anyConditionsQuery.push(`IF NEW.${subject.split('.')[1]} ${operator} '${value}'`);
                }
                query += anyConditionsQuery.join(' ELSE ');
            }

            if (actions.length > 0) {
                query += ' THEN ';
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

            query += ';END IF; END';
            console.log(query);

            // Set the hidden input value
            document.getElementById('trigger_query').value = query;
        }
    </script>
@endsection
