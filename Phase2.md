<img width="150px" src="https://w0244079.github.io/nscc/nscc-jpeg.jpg" >

## INET 2005 - Final Assignment - Phase 2

### Chirper Application Enhancement: Adding "Likes" Feature

### **Overview**
This phase requires in-class sign-off from your instructor (ie. brief code review). It is vital that you use your class time wisely to ask questions so that you know when the requirements are met. You must be present in class to demonstrate your solution to the instructor in order to receive credit for this phase.

In this task, you will extend the existing Chirper application by adding a "Likes" feature. Users should be able to:
- Like a chirp.
- Unlike a chirp.
- View the total number of likes on each chirp.

This feature will involve changes to the database, backend logic, and frontend interface.

---

### **Requirements**

#### **1. Database**

- Create a `likes` table with the following columns:
  - `id`: Primary key.
  - `user_id`: Foreign key referencing the `id` column in the `users` table.
  - `chirp_id`: Foreign key referencing the `id` column in the `chirps` table.
  - `timestamps`: To track when a like was added or removed.
- Ensure that a user cannot like the same chirp multiple times. This can be enforced using a unique constraint on `user_id` and `chirp_id`.

---

#### **2. Backend Logic**

1. **Routes**
   - Add the following routes:
     - **POST `/chirps/{chirp}/like`**: To like a chirp.
     - **DELETE `/chirps/{chirp}/like`**: To unlike a chirp.

2. **Controller**
   - Create a `LikeController` with two methods:
     - **`store(Request $request, Chirp $chirp)`**:
       - Check if the user has already liked the chirp.
       - If not, create a new record in the `likes` table.
     - **`destroy(Request $request, Chirp $chirp)`**:
       - Remove the like record for the current user and chirp.

3. **Model Updates**
   - Update the `Chirp` model:
     - Add a `likes()` method to define a one-to-many relationship with the `Like` model.
   - Update the `Like` model to allow mass assignment for `user_id` and `chirp_id`.

---

#### **3. Frontend Interface**

1. **Display Buttons**
   - On the chirp listing page:
     - Show a "Like" button if the user has not liked the chirp.
     - Show an "Unlike" button if the user has already liked the chirp.
     - Display the total number of likes for each chirp.

2. **Blade Template Example**
   - Add forms to handle liking/unliking:
     ```html
     @foreach ($chirps as $chirp)
         <div class="chirp">
             <p>{{ $chirp->content }}</p>
             <div>
                 @if ($chirp->likes->contains('user_id', auth()->id()))
                     <form method="POST" action="{{ route('chirps.unlike', $chirp) }}">
                         @csrf
                         @method('DELETE')
                         <button type="submit">Unlike</button>
                     </form>
                 @else
                     <form method="POST" action="{{ route('chirps.like', $chirp) }}">
                         @csrf
                         <button type="submit">Like</button>
                     </form>
                 @endif
                 <span>{{ $chirp->likes->count() }} Likes</span>
             </div>
         </div>
     @endforeach
     ```

3. **AJAX Implementation**
   - Research how to modify the functionality to use JavaScript to handle like/unlike actions without reloading the page.

---

#### **4. Additional Notes**
- Test your feature to ensure:
  - Users can like a chirp only once.
  - The total number of likes updates correctly.
  - UI reflects the correct state (liked/unliked).
- Follow Laravel conventions and best practices.

---

## **Submission Instructions**
- Commit and push your changes to your final assignment repository.


---


