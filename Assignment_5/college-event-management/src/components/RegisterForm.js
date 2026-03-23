import { useEffect, useMemo, useState } from "react";

function RegisterForm({ handleSubmit, defaultEvent, events }) {
  const eventFees = useMemo(
    () =>
      events.reduce((fees, event) => {
        fees[event.name] = event.fee;
        return fees;
      }, {}),
    [events]
  );

  const [formData, setFormData] = useState({
    name: "",
    gender: "",
    email: "",
    phone: "",
    college: "",
    department: "",
    year: "",
    city: "",
    state: "",
    event: "",
    paymentAmount: "",
    paymentMethod: ""
  });

  useEffect(() => {
    if (!defaultEvent) return;

    setFormData((prev) => ({
      ...prev,
      event: defaultEvent,
      paymentAmount: eventFees[defaultEvent] || ""
    }));
  }, [defaultEvent, eventFees]);

  const handleChange = (e) => {
    const { name, value } = e.target;

    if (name === "event") {
      setFormData((prev) => ({
        ...prev,
        event: value,
        paymentAmount: eventFees[value] || ""
      }));
      return;
    }

    setFormData((prev) => ({
      ...prev,
      [name]: value
    }));
  };

  return (
    <div className="form">
      <h2>Event Registration</h2>
      <p className="form-subtitle">Fill in your details to reserve your spot.</p>

      <form onSubmit={(e) => handleSubmit(e, formData)}>
        <input
          type="text"
          name="name"
          placeholder="Full Name"
          onChange={handleChange}
          value={formData.name}
          required
        />

        <select name="gender" onChange={handleChange} value={formData.gender} required>
          <option value="">Select Gender</option>
          <option>Male</option>
          <option>Female</option>
          <option>Other</option>
        </select>

        <input
          type="email"
          name="email"
          placeholder="Email"
          onChange={handleChange}
          value={formData.email}
          required
        />

        <input
          type="tel"
          name="phone"
          placeholder="Phone Number"
          onChange={handleChange}
          value={formData.phone}
          required
        />

        <input
          type="text"
          name="college"
          placeholder="College Name"
          onChange={handleChange}
          value={formData.college}
          required
        />

        <input
          type="text"
          name="department"
          placeholder="Department"
          onChange={handleChange}
          value={formData.department}
          required
        />

        <select name="year" onChange={handleChange} value={formData.year} required>
          <option value="">Select Year</option>
          <option>First Year</option>
          <option>Second Year</option>
          <option>Third Year</option>
          <option>Final Year</option>
        </select>

        <input
          type="text"
          name="city"
          placeholder="City"
          onChange={handleChange}
          value={formData.city}
          required
        />

        <input
          type="text"
          name="state"
          placeholder="State"
          onChange={handleChange}
          value={formData.state}
          required
        />

        <select name="event" onChange={handleChange} value={formData.event} required>
          <option value="">Select Event</option>
          {events.map((event) => (
            <option key={event.name} value={event.name}>
              {event.name}
            </option>
          ))}
        </select>

        <input
          type="number"
          name="paymentAmount"
          value={formData.paymentAmount}
          readOnly
          placeholder="Registration Fee"
        />

        <select
          name="paymentMethod"
          onChange={handleChange}
          value={formData.paymentMethod}
          required
        >
          <option value="">Select Payment Method</option>
          <option>UPI</option>
          <option>Cash</option>
          <option>Debit Card</option>
          <option>Credit Card</option>
        </select>

        <button className="btn submit-btn" type="submit">
          Register Now
        </button>
      </form>
    </div>
  );
}

export default RegisterForm;
