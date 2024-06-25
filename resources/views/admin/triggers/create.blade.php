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
        </form>
    </div>
    <script>
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
                    text: 'Ticket Subject',
                    value: 'ticket.subject'
                },
                {
                    text: 'Ticket Body',
                    value: 'ticket.body'
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
                    text: 'Ticket Number of Attachments',
                    value: 'ticket.attachments'
                },
                {
                    text: 'Ticket Assignee',
                    value: 'ticket.assignee'
                },
                {
                    text: 'Ticket Mailbox address',
                    value: 'ticket.mailbox'
                },
                // Add more options as needed
            ];
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

                let conditionTypeOptions = [];
                if (subjectSelect.value === 'user.email') {
                    conditionTypeOptions = [{
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
                    ];
                } else if (subjectSelect.value === 'user.name') {
                    conditionTypeOptions = [{
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
                    ];
                } else if (subjectSelect.value === 'ticket.status') {
                    conditionTypeOptions = [{
                            text: 'is',
                            value: '='
                        },
                        {
                            text: 'not equals',
                            value: '!='
                        },
                    ];
                } else if (subjectSelect.value === 'ticket.category') {
                    conditionTypeOptions = [{
                            text: 'is',
                            value: '='
                        },
                        {
                            text: 'not equals',
                            value: '!='
                        },
                    ];
                } else {
                    conditionTypeOptions = [{
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
                    ];
                }

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
            const actionOptions = [{
                    text: 'Select an action',
                    value: ''
                },
                {
                    text: 'Ticket: Assign to Agent',
                    value: 'UPDATE tickets SET agent_id = ?'
                },
                {
                    text: 'Ticket: Change status',
                    value: 'UPDATE tickets SET status = ?'
                },
        
            ];
            actionOptions.forEach(option => {
                const optionElement = document.createElement('option');
                optionElement.text = option.text;
                optionElement.value = option.value;
                actionSelect.appendChild(optionElement);
            });
            flexContainer.appendChild(actionSelect);

            // Second input: Value
            const valueInput = document.createElement('select');
            valueInput.name = containerId + '[]';
            valueInput.className = 'form-control mt-2';
            flexContainer.appendChild(valueInput);

            actionSelect.addEventListener('change', function() {
                valueInput.innerHTML = ''; // Clear previous options
                if (actionSelect.value === 'UPDATE tickets SET status = ?') {
                    const statusOptions = [
                        { text: 'Open', value: 'open' },
                        { text: 'Closed', value: 'closed' }
                    ];
                    statusOptions.forEach(option => {
                        const optionElement = document.createElement('option');
                        optionElement.text = option.text;
                        optionElement.value = option.value;
                        valueInput.appendChild(optionElement);
                    });
                } else if (actionSelect.value === 'UPDATE tickets SET agent_id = ?') {
                    const agents = @json($agents); // Assuming $agents is passed from the backend
                    agents.forEach(agent => {
                        const optionElement = document.createElement('option');
                        optionElement.text = agent.name;
                        optionElement.value = agent.id;
                        valueInput.appendChild(optionElement);
                    });
                } else {
                    const defaultOption = document.createElement('option');
                    defaultOption.text = 'Enter value';
                    defaultOption.value = '';
                    valueInput.appendChild(defaultOption);
                }
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

            let query = `CREATE TRIGGER ${document.getElementById('name').value} AFTER INSERT ON `;
            if (allConditions.length > 0 || anyConditions.length > 0) {
                const subjectSelect = allConditions.length > 0 ? allConditions[0].children[0] : anyConditions[0].children[0];
                if (subjectSelect.value.startsWith('ticket.')) {
                    query += 'tickets FOR EACH ROW BEGIN ';
                } else if (subjectSelect.value.startsWith('user.')) {
                    query += 'users FOR EACH ROW BEGIN ';
                }
            }

            let conditionsQuery = [];
            for (let condition of allConditions) {
                const subject = condition.children[0].value;
                const operator = condition.children[1].value;
                const value = condition.children[2].value;
                conditionsQuery.push(`IF NEW.${subject.split('.')[1]} ${operator} '${value}' THEN`);
            }
            if (conditionsQuery.length > 0) {
                query += conditionsQuery.join(' ');
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
                    anyConditionsQuery.push(`IF NEW.${subject.split('.')[1]} ${operator} '${value}' THEN`);
                }
                query += anyConditionsQuery.join(' ELSE ');
            }

            if (actions.length > 0) {
                query += ' ';
                for (let action of actions) {
                    const actionValue = action.children[0].value;
                    query += `${actionValue}; `;
                }
            }

            query += ' END IF; END;';
            console.log(query);
            // Perform actions based on the query result
        }
    </script>
@endsection
