function EventDetails({ event, onRegister }) {
  if (!event) return null;

  return (
    <article className="event-details">
      <div className="details-image">
        <img src={event.image} alt={event.name} />
      </div>

      <div className="details-content">
        <h3>{event.name}</h3>

        <div className="event-meta">
          <span>Date: {event.date}</span>
          <span>Time: {event.time}</span>
          <span>Venue: {event.venue}</span>
          <span>Fee: Rs. {event.fee}</span>
          <span>Seats: {event.seats}</span>
        </div>

        <p className="event-description">{event.description}</p>

        <div className="event-details-grid">
          <section className="detail-panel">
            <h4>Key Highlights</h4>
            <ul>
              {event.highlights?.map((item) => (
                <li key={item}>{item}</li>
              ))}
            </ul>
          </section>

          <section className="detail-panel">
            <h4>Event Schedule</h4>
            <ul>
              {event.agenda?.map((item) => (
                <li key={item}>{item}</li>
              ))}
            </ul>
          </section>
        </div>

        <p className="event-organizer">
          Organized by {event.organizer} | Coordinator: {event.coordinator}
        </p>

        <button className="btn register-btn" onClick={() => onRegister(event)}>
          Register for This Event
        </button>
      </div>
    </article>
  );
}

export default EventDetails;
