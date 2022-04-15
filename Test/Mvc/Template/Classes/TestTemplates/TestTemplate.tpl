		{% if $user && $user.cars %}
			name: {$user.name}
			{% foreach $car in $user.cars %}
				name of car: {$car.name}
			{% endforeach %}
		{% endif %}
		{% else %}
			There is no user in the system.
		{% endelse %}
