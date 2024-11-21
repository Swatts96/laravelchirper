<img width="150px" src="https://w0244079.github.io/nscc/nscc-jpeg.jpg" >

## INET 2005 - Final Assignment - Phase 3

### Chirper Application Enhancement: Add from list of features

### **Overview**
This phase requires in-class sign-off from your instructor (ie. brief code review). It is vital that you use your class time wisely to ask questions so that you know when the requirements are met. You must be present in class to demonstrate your solution to the instructor in order to receive credit for this phase. You are expected to ask for feedback on your implementations as they are completed. (ie. not all at the end of the semester)

In this phase, you will extend the existing Chirper application by adding from the list of proposed features listed below. Using all tools available to you (including AI tools), research and implement three (3) of the features listed below.

Grading of this phase will be as follows:

- One (1) feature adequately implemented - 60%
- Two (2) features adequately implemented - 80%
- Three (3) or more features adequately implemented - 100%

---

### **List of proposed features**

#### **User Engagement**
- **Real-time Like updates:** Implement real-time updates for the like count using **Laravel Reverb** (or **Laravel Echo** with a broadcasting service like **Pusher**) 
- **Comments/Replies:** Add a simple commenting system for chirps so that other users can add comments to chirps.
- **Follow System:** Implement a follow feature to create a personalized feed based on the chirps of followed users.
- **Bookmarks:** Let users save chirps for later reference.

#### **Multimedia Enhancements**
- **Image/Video Uploads:** Enable users to attach media files to chirps, using Laravel's file storage capabilities.
- **GIF Integration:** Allow users to search and post GIFs via an API like Giphy.

#### **Content Moderation**
- **Reporting System:** Allow users to flag a chirp as inappropriate, alerting/notifying the creator of the chirp.

#### **Notifications and Interactivity**
- **Real-Time Notifications:** Use Laravel Echo and Pusher to notify users of likes, comments, or new followers.
- **Direct Messaging:** Add a private messaging system for user-to-user communication.

#### **Advanced Search and Discovery**
- **Hashtags:** Enable users to use hashtags in chirps and view chirps grouped by hashtags.
- **Search Feature:** Allow searching for chirps, users, or hashtags with a robust query builder.
- **Trending Chirps:** Highlight trending chirps based on metrics like likes, comments, and shares.

#### **Analytics and Insights**
- **User Stats:** Display stats for each user, such as total chirps, likes, and followers.
- **Chirp Analytics:** Show engagement metrics (likes, comments, views) for individual chirps.

#### **Admin and Backend Features**
- **Admin Dashboard:** Create a dashboard for managing users, reports, and flagged content.
- **API Integration:** Provide an API for accessing chirps programmatically, allowing for mobile app development or integrations.

#### **Accessibility and Customization**
- **Localization:** Support multiple languages for a global user base.

#### **Propose your own feature**
- Propose a feature to your instructor that you'd like to implement. (Must be approved beforehand)
  
---

## **Submission Instructions**
- Commit and push your changes to your final assignment repository.
