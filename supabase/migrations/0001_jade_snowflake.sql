/*
  # Initial Schema Setup for Scheduling System

  1. New Tables
    - `services`: Stores available services
      - `id` (uuid, primary key)
      - `name` (text)
      - `description` (text)
      - `duration` (integer, minutes)
      - `price` (integer, cents)
      - `created_at` (timestamp)
    
    - `providers`: Stores service providers
      - `id` (uuid, primary key)
      - `user_id` (uuid, references auth.users)
      - `name` (text)
      - `email` (text)
      - `phone` (text)
      - `specialization` (text)
      - `created_at` (timestamp)
    
    - `appointments`: Stores appointments
      - `id` (uuid, primary key)
      - `service_id` (uuid, references services)
      - `provider_id` (uuid, references providers)
      - `client_id` (uuid, references auth.users)
      - `start_time` (timestamp)
      - `end_time` (timestamp)
      - `status` (enum: pending, confirmed, cancelled)
      - `notes` (text)
      - `created_at` (timestamp)

  2. Security
    - Enable RLS on all tables
    - Add policies for authenticated users
*/

-- Create enum types
CREATE TYPE appointment_status AS ENUM ('pending', 'confirmed', 'cancelled');

-- Create services table
CREATE TABLE IF NOT EXISTS services (
  id uuid PRIMARY KEY DEFAULT gen_random_uuid(),
  name text NOT NULL,
  description text NOT NULL,
  duration integer NOT NULL,
  price integer NOT NULL,
  created_at timestamptz DEFAULT now()
);

-- Create providers table
CREATE TABLE IF NOT EXISTS providers (
  id uuid PRIMARY KEY DEFAULT gen_random_uuid(),
  user_id uuid REFERENCES auth.users NOT NULL,
  name text NOT NULL,
  email text NOT NULL,
  phone text NOT NULL,
  specialization text NOT NULL,
  created_at timestamptz DEFAULT now()
);

-- Create appointments table
CREATE TABLE IF NOT EXISTS appointments (
  id uuid PRIMARY KEY DEFAULT gen_random_uuid(),
  service_id uuid REFERENCES services NOT NULL,
  provider_id uuid REFERENCES providers NOT NULL,
  client_id uuid REFERENCES auth.users NOT NULL,
  start_time timestamptz NOT NULL,
  end_time timestamptz NOT NULL,
  status appointment_status DEFAULT 'pending',
  notes text,
  created_at timestamptz DEFAULT now()
);

-- Enable Row Level Security
ALTER TABLE services ENABLE ROW LEVEL SECURITY;
ALTER TABLE providers ENABLE ROW LEVEL SECURITY;
ALTER TABLE appointments ENABLE ROW LEVEL SECURITY;

-- Create policies for services
CREATE POLICY "Services are viewable by everyone"
  ON services FOR SELECT
  TO authenticated
  USING (true);

-- Create policies for providers
CREATE POLICY "Providers are viewable by everyone"
  ON providers FOR SELECT
  TO authenticated
  USING (true);

CREATE POLICY "Providers can update their own profile"
  ON providers FOR UPDATE
  TO authenticated
  USING (auth.uid() = user_id);

-- Create policies for appointments
CREATE POLICY "Users can view their own appointments"
  ON appointments FOR SELECT
  TO authenticated
  USING (
    auth.uid() = client_id OR 
    auth.uid() IN (
      SELECT user_id FROM providers WHERE id = appointments.provider_id
    )
  );

CREATE POLICY "Users can create appointments"
  ON appointments FOR INSERT
  TO authenticated
  WITH CHECK (auth.uid() = client_id);

CREATE POLICY "Users can update their own appointments"
  ON appointments FOR UPDATE
  TO authenticated
  USING (
    auth.uid() = client_id OR 
    auth.uid() IN (
      SELECT user_id FROM providers WHERE id = appointments.provider_id
    )
  );